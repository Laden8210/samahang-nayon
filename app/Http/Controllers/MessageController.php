<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Guest;
use App\Models\Employee;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.message.index');
    }

    public function sendGuestMessage(Request $request)
    {

        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['error' => 'Unauthorized'], 200);
        }

        $request->validate([
            'Message' => 'required|string'
        ]);

        $message = new Message();
        $message->GuestId = $guest->GuestId;

        $message->IsReadEmployee = false;
        $message->IsReadGuest = false;
        $message->Message = $request->Message;
        $message->isGuestMessage = true;
        $message->DateSent = now()->toDateString();
        $message->TimeSent = now()->toTimeString();
        $message->save();

        if ($message) {
            return response()->json(['message' => 'Message sent successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to send message'], 400);
        }
    }
    public function getGuestMessages()
    {
        $guest = Auth::guard('api')->user();

        if (!$guest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Get all employees related to the guest, even those without messages
        $employees = Employee::select('EmployeeId', 'FirstName', 'LastName', 'Position')->get();

        // Fetch messages related to the guest
        $messages = Message::where('GuestId', $guest->GuestId)
            ->with(['employee' => function($query) {
                $query->select('EmployeeId', 'FirstName', 'LastName', 'Position');
            }])
            ->orderBy('DateSent', 'desc')
            ->orderBy('TimeSent', 'desc')
            ->get();

        // Group messages by EmployeeId
        $groupedMessages = $messages->groupBy('EmployeeId')->map(function ($employeeMessages) {
            $latestMessage = $employeeMessages->first(); // Get the latest message for this employee
            return [
                'message_id' => $latestMessage->MessageId,
                'message' => $latestMessage->Message,
                'date_sent' => $latestMessage->DateSent,
                'time_sent' => date('g:i A', strtotime($latestMessage->TimeSent)),
                'is_read_guest' => $latestMessage->IsReadGuest,

                'employee_name' => $latestMessage->employee
                    ? $latestMessage->employee->FirstName . " " . $latestMessage->employee->LastName
                    : null,
            ];
        });

        // Prepare the response to include all employees
        $response = $employees->map(function ($employee) use ($groupedMessages, $messages) {
            // Count total unread messages for the current employee
            $totalUnreadMessages = $messages->where('EmployeeId', $employee->EmployeeId)
                ->where('IsReadGuest', false)
                ->where('isGuestMessage', true)
                ->count();

            // Handle both employees with and without messages
            return [
                'employee_id' => $employee->EmployeeId,
                'employee_name' => $employee->FirstName . " " . $employee->LastName,
                'position' => $employee->Position,
                'message_id' => $groupedMessages->has($employee->EmployeeId) ? $groupedMessages[$employee->EmployeeId]['message_id'] : null,
                'message' => $groupedMessages->has($employee->EmployeeId) ? $groupedMessages[$employee->EmployeeId]['message'] : null,
                'date_sent' => $groupedMessages->has($employee->EmployeeId) ? $groupedMessages[$employee->EmployeeId]['date_sent'] : null,
                'time_sent' => $groupedMessages->has($employee->EmployeeId) ? $groupedMessages[$employee->EmployeeId]['time_sent'] : null,
                'is_read_guest' => $groupedMessages->has($employee->EmployeeId) ? $groupedMessages[$employee->EmployeeId]['is_read_guest'] : null,
                'total_unread_messages' => $totalUnreadMessages,
            ];
        });

        return response()->json($response->values()->all(), 200);
    }



    public function retrieveUserMessage(Request $request)
    {
        $guest = Auth::guard('api')->user();
        if (!$guest) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $message = Message::where('GuestId', $guest->GuestId)

            ->with(['employee' => function($query) {
                $query->select('EmployeeId', 'FirstName', 'LastName', 'Position');
            }])
            ->orderBy('DateSent', 'asc')
            ->orderBy('TimeSent', 'asc')
            ->get();

        return response()->json($message, 200);
    }




}

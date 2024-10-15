@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1 class="text-2xl font-bold p-2">Dashboard</h1>

    <div class="bg-white p-4 rounded">
        <h2 class="font-bold">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
            <x-dashboard-card title="Available Room" count="{{ $availableRooms }}" />
            <x-dashboard-card title="Occupied Room" count="{{ $occupiedRooms }}" />
            <x-dashboard-card title="Today's Check In" count="{{ $totalCheckIn }}" />
            <x-dashboard-card title="Today's Check Out" count="{{ $totalCheckOut }}" />
            <x-dashboard-card title="Today's Booking" count="{{ $totalBooking }}" />
            <x-dashboard-card title="Today's Reservation" count="{{ $totalReservation }}" />
            <x-dashboard-card title="Total Guest" count="{{ $user }}" />
        </div>

        <div class="grid grid-cols-1 w-full h-96 bg-white p-4 mt-10 rounded shadow">
            <!-- Adjusted canvas element -->
            <canvas id="myChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Example data passed from Laravel to JavaScript
        const data = {
            labels: {!! json_encode($labels) !!},  // Data labels from the controller (e.g., months)
            datasets: [{
                label: 'Room Occupancy',
                data: {!! json_encode($roomOccupancyData) !!},  // Data points for the chart
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',  // Chart type (e.g., 'bar', 'line', 'pie', etc.)
            data: data,
            options: {
                maintainAspectRatio: false, // Ensure the chart uses all available space
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333',  // Make label color clearer
                        }
                    },
                    x: {
                        ticks: {
                            color: '#333',  // Make label color clearer
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#333',  // Make the legend text clearer
                        }
                    }
                }
            }
        };

        // Render the chart
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

@endsection

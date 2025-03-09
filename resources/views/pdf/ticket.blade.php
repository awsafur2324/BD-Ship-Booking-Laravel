<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .ticket {
            width: 700px;
            background-color: #fff;
            border: 2px solid #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-header h1 {
            font-size: 30px;
            color: #2c3e50;
        }
        .ticket-header p {
            font-size: 16px;
            color: #7f8c8d;
        }
        .ticket-body {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .left-info {
            width: 100%;
        }
        .right-info {
            width: 100%;
            text-align: right;
        }
        .ticket-body h3 {
            color: #16a085;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .ticket-body p {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .ticket-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
        .footer-icon {
            color: #16a085;
        }
        .separator {
            font-size: 20px;
            font-weight: bold;
            color: #16a085;
            margin: 10px 0;
        }
        .bar-code {
            text-align: center;
            margin-top: 20px;
        }
        .bar-code img {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Ticket Header -->
        <div class="ticket-header">
            <h1>BD Ship Booking</h1>
            <p>Your journey starts here</p>
        </div>

        <!-- Ticket Body -->
        <div class="ticket-body">
            <div class="left-info">
                <h3>Departure Details</h3>
                <p><strong>Date:</strong> {{ $date }}</p>
                <p><strong>Ship:</strong> {{ $ship_name }}</p>
                <p><strong>Couch No:</strong> {{ $couch_no }}</p>
                <p><strong>Departure:</strong> {{ $departure_point }}</p>
                <p><strong>Arrival:</strong> {{ $arrival_point }}</p>
            </div>
            <div class="right-info">
                <h3>Passenger Info</h3>
                <p><strong>Name:</strong> {{ $user_name }}</p>
                <p><strong>Phone:</strong> {{ $user_phone }}</p>
                <p><strong>Seats:</strong> {{ $seats }}</p>
                <p><strong>Price:</strong> {{ $total_price }}</p>
            </div>
        </div>

        <!-- Ticket Footer -->
        <div class="ticket-footer">
            <p>Thank you for choosing us!</p>
            <p class="separator">—————————————————————————————————</p>
            <p>Have a pleasant journey!</p>
            <p class="footer-icon"><i class="far fa-smile"></i></p>
        </div>

    </div>
</body>
</html>

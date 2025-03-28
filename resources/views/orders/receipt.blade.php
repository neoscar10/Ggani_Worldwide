<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - Ggani-Worldwide</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f8f9fa; 
            margin: 0; 
            padding: 0;
        }
        .container { 
            width: 80%; 
            margin: 40px auto; 
            padding: 20px; 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); 
        }
        .header { 
            text-align: center; 
            font-size: 28px; 
            font-weight: bold; 
            color: #333; 
            padding-bottom: 10px; 
            border-bottom: 2px solid #ddd; 
        }
        .store-name {
            text-align: center;
            font-size: 20px;
            color: gray;
            font-weight: bold;
            margin-top: 5px;
        }
        .details { margin-top: 20px; font-size: 16px; color: #555; }
        .details p { margin: 5px 0; }
        .items { 
            margin-top: 20px; 
            border-collapse: collapse; 
            width: 100%; 
        }
        .items th, .items td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        .items th { 
            background-color: gray; 
            color: white; 
            text-transform: uppercase; 
        }
        .total { 
            margin-top: 20px; 
            font-size: 18px; 
            font-weight: bold; 
            text-align: right; 
        }
        .thank-you { 
            text-align: center; 
            margin-top: 30px; 
            font-size: 18px; 
            color: gray; 
            font-weight: bold; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Order Receipt</div>
        <div class="store-name">Ggani-Worldwide</div>

        <div class="details">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Customer Name:</strong> {{ $order->user->name }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_amount, 2) }}</td>
                    <td>${{ number_format($item->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <p>Grand Total: ${{ number_format($order->grand_total, 2) }}</p>
        </div>

        <div class="thank-you">
            Thank you for shopping with Ggani-Worldwide! We appreciate your business.
        </div>
    </div>
</body>
</html>

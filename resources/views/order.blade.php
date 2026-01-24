<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<div class="container py-4">
    @if($order)
        <h1 class="text-center">Замовлення</h1>
        <div class="table-responsive mt-4">
            <table class="table table-bordered align-middle">
                <tbody>
                <tr>
                    <th class="w-25 bg-light">Назва товару:</th>
                    <td>{{ $order->name }}</td>
                </tr>
                <tr>
                    <th class="w-25 bg-light">Кількість:</th>
                    <td>{{ $order->quantity }}</td>
                </tr>
                <tr>
                    <th class="w-25 bg-light">Ціна:</th>
                    <td>{{ $order->price }} грн</td>
                </tr>
                <tr>
                    <th class="w-25 bg-light">Знижка:</th>
                    <td>{{ $order->discount }}%</td>
                </tr>
                <tr>
                    <th class="w-25 bg-light">Інформація про доставку:</th>
                    <td>{{ $order->deliveryPoint->format() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info mt-4">
            <b>Передайте параметри в URL: provider, delivery, address</b>
            <p class="mt-2"><b>Наприклад: <a href="#">http://localhost:8888/?provider=НоваПошта&delivery=Поштомат 30222&address=№123 м. Київ, вул. Хрещатик 1</a></b></p>
        </div>
    @endif
</div>
</body>
</html>

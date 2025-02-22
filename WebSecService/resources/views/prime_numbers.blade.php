<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Numbers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card m-4">
            <div class="card-header">Prime Numbers</div>
            <div class="card-body">
                @php
                    function isPrime($number) {
                        if ($number < 2) return false;
                        for ($i = 2; $i <= sqrt($number); $i++) {
                            if ($number % $i == 0) return false;
                        }
                        return true;
                    }
                @endphp

                @foreach (range(1, 100) as $i)
                    @if (isPrime($i))
                        <span class="badge bg-primary">{{ $i }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $i }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>

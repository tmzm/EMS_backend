<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    direction: rtl;
    text-align: right;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    color: #4CAF50;
    font-size: 24px;
    margin-bottom: 20px;
}

p {
    font-size: 18px;
    color: #333;
    line-height: 1.6;
}

.details {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 5px;
    margin: 20px 0;
}

.details p {
    margin: 10px 0;
}

a {
    color: #4CAF50;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
<div class="container">
    <h1>Congratulations!</h1>
    <p>You have been successfully accepted into the company. You can now log in to your account using the following details:</p>
    <div class="details">
        <p><strong>Dashboard Link:</strong> <a href="{{ $url }}">{{ $url }}</a></p>
        <p><strong>Email:</strong> {{ $email }}</p>
    </div>
    <p>If you have any questions, feel free to contact us.</p>
</div>
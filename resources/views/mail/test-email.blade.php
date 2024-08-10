<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        padding: 20px;
        direction: rtl;
        text-align: center;
    }

    .email-container {
        background-color: #fff;
        max-width: 600px;
        margin: 0 auto;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .email-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 100px;
        margin-bottom: 10px;
    }

    .email-header h1 {
        font-size: 28px;
        color: #0056b3;
        margin: 0;
    }


    .email-body p {
        font-size: 16px;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .otp-code {
        font-size: 36px;
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 10px 20px;
        border-radius: 5px;
        display: inline-block;
        margin: 20px 0;
        letter-spacing: 5px;
    }
    .email-body strong {
        color: #0056b3;
    }
</style>
<div class="email-container">
    <div class="email-header">
        <img src="logo.png" alt="Amakin Expo Logo" class="logo">
        <h1>Amakin Expo</h1>
    </div>
    <div class="email-body">
        <p>Hello, {{ $name }}</p>
        <p>You have requested a verification code (OTP) to log into your account <strong>Amakin Expo</strong>. Please use the following code to complete the login process:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>If you did not request this code, please ignore this email.</p>
        <p>Thank you, </p>
        <p><strong>Amakin Expo</strong> Team</p>
    </div>
</div>
    
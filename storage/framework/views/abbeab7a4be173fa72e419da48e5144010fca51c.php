<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password | AskDocPH</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f7f9;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #4a4a4a;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-top: 40px;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #1a202c;
            font-size: 22px;
            margin-top: 0;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 24px;
            color: #4b5563;
        }
        .button-wrapper {
            text-align: center;
            margin: 32px 0;
        }
        .button {
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .footer {
            text-align: center;
            padding: 24px;
            font-size: 13px;
            color: #9ca3af;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 24px 0;
        }
        .sub-text {
            font-size: 12px;
            color: #6b7280;
            word-break: break-all;
        }
        @media  only screen and (max-width: 600px) {
            .main {
                border-radius: 0;
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" role="presentation">
            <tr>
                <td class="header">
                    <h1>AskDocPH</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>Hello, <?php echo e($user->fname); ?>!</h2>
                    <p>We received a request to reset the password for your account associated with <strong><?php echo e($user->email); ?></strong>.</p>
                    <p>No changes have been made to your account yet. You can reset your password by clicking the button below:</p>
                    
                    <div class="button-wrapper">
                        <a href="<?php echo e($url); ?>" class="button">Reset Password</a>
                    </div>
                    
                    <p>This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.</p>
                    
                    <div class="divider"></div>
                    
                    <p class="sub-text">
                        If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                        <br>
                        <a href="<?php echo e($url); ?>" style="color: #2563eb;"><?php echo e($url); ?></a>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    &copy; <?php echo e(date('Y')); ?> AskDocPH. All rights reserved.<br>
                    Caring for your mental wellness, always.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php /**PATH C:\websystem\resources\views/emails/password-reset.blade.php ENDPATH**/ ?>
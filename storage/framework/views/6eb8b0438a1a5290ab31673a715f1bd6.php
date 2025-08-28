<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test API</title>
</head>

<body>
    <form action="<?php echo e(route('content.create')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3NTU5NDA1NjMsImV4cCI6MTc1NTk0NDE2MywibmJmIjoxNzU1OTQwNTYzLCJqdGkiOiJqTTdlRDFIQnhNa29QRFkyIiwic3ViIjoiMiIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.9fshUCwilhOW-njpS5PqskGuuqv2JrMZgK3rOmtJbYo">

        <input type="file" name="image">
        <button type="submit">Submit</button>
    </form>
</body>

</html><?php /**PATH D:\laragon\www\wp_monkey\smutly-hatemverymuch_backend\resources\views/test.blade.php ENDPATH**/ ?>
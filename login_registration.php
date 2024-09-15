<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register | Cooking Companion</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
        }

        .container {
            max-width: 1200px;
        }

        h3 {
            font-weight: bold;
            color: #333;
        }

        hr {
            border: 1px solid #ddd;
        }

        /* Form Styling */
        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #6e45e2;
            box-shadow: 0 0 0 0.2rem rgba(110, 107, 237, 0.25);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .invalid-feedback {
            color: #e3342f;
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: #6e45e2;
            border-color: #6e45e2;
            color: #fff;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #5c3ba1;
            border-color: #5c3ba1;
        }

        /* Alert Messages */
        .pop_msg {
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Layout Styles */
        .row {
            margin-right: 0;
            margin-left: 0;
        }

        .col-md-4,
        .col-md-8 {
            padding: 1rem;
        }

        .border-start {
            border-left: 1px solid #ddd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-md-4,
            .col-md-8 {
                padding: 0.5rem;
            }

            .col-md-4 {
                border-bottom: 1px solid #ddd;
            }

            .border-start {
                border-left: none;
                border-top: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5 mt-4">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4 py-5 my-4">
                    <h3><b>Login Here</b></h3>
                    <hr>
                    <form action="" id="login-form">
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" name="username" class="form-control form-control-sm rounded-0" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm rounded-0" required>
                        </div>
                        <div class="form-group my-1 pt-2">
                            <div class="w-100 d-flex justify-content-end">
                                <button class="btn btn-sm btn-primary rounded-0">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 border-start py-5 my-4">
                    <div class="col-sm-6 offset-sm-2">
                        <h3><b>Create New Account</b></h3>
                        <form action="" id="sign-up">
                            <div class="form-group">
                                <label for="fullname" class="control-label">Fullname</label>
                                <input type="text" name="fullname" class="form-control form-control-sm rounded-0" required>
                                <div class="invalid-feedback" id="fullname-error" style="display: none;">
                                    Fullname should not contain numbers.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" name="username" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" name="password" class="form-control form-control-sm rounded-0" required>
                            </div>
                            <div class="form-group my-1 pt-2">
                                <div class="w-100 d-flex justify-content-end">
                                    <button class="btn btn-sm btn-primary rounded-0">Create Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#login-form').submit(function(e){
                e.preventDefault();
                $('.pop_msg').remove();
                var _this = $(this);
                var _el = $('<div>').addClass('pop_msg');
                _this.find('button').attr('disabled', true);
                _this.find('button[type="submit"]').text('Logging in...');
                $.ajax({
                    url: './Actions.php?a=login_user',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    error: err => {
                        console.log(err);
                        _el.addClass('alert alert-danger');
                        _el.text("An error occurred.");
                        _this.prepend(_el);
                        _el.show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Login');
                    },
                    success: function(resp) {
                        if(resp.status == 'success'){
                            location.replace('./');
                        }else{
                            _el.addClass('alert alert-danger');
                        }
                        _el.text(resp.msg);
                        _el.hide();
                        _this.prepend(_el);
                        _el.show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Login');
                    }
                });
            });

            $('#sign-up').submit(function(e){
                e.preventDefault();
                $('.pop_msg').remove();
                var _this = $(this);
                var _el = $('<div>').addClass('pop_msg');
                var fullname = $('input[name="fullname"]').val();
                var fullnameError = $('#fullname-error');

                // Check if fullname contains any numbers
                if (/\d/.test(fullname)) {
                    fullnameError.show();
                    return;
                } else {
                    fullnameError.hide();
                }

                _this.find('button').attr('disabled', true);
                _this.find('button[type="submit"]').text('Creating account...');
                $.ajax({
                    url: './Actions.php?a=user_register',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    error: err => {
                        console.log(err);
                        _el.addClass('alert alert-danger');
                        _el.text("An error occurred.");
                        _this.prepend(_el);
                        _el.show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Create Account');
                    },
                    success: function(resp) {
                        if(resp.status == 'success'){
                            _el.addClass('alert alert-success');
                        }else{
                            _el.addClass('alert alert-danger');
                        }
                        _el.text(resp.msg);
                        _el.hide();
                        _this.prepend(_el);
                        _el.show('slow');
                        _this.find('button').attr('disabled', false);
                        _this.find('button[type="submit"]').text('Create Account');
                    }
                });
            });
        });
    </script>
</body>
</html>

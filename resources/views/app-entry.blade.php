<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--Made by an engineer for engineers-->
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.8/angular.min.js"></script>
    <script src="{{ asset('app.js') }}" defer></script>
    <style>
        .container {
            padding-top: 15%;
        }
    </style>
</head>
<body ng-app="authyDemo">
<div class="container center-block">
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Account Security Demo</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <p>
                                Simple Authy Implementations of both Phone Verification and 2FA Authentication
                            </p>
                            <ul>
                                <li><a href="https://www.twilio.com/authy">Authy Info</a></li>
                                <li><a href="https://github.com/AuthySE/Authy-API-Samples">Authy CLI Samples</a></li>
                                <li><a href="https://github.com/AuthySE/Authy-API-Samples/tree/master/postman">Authy
                                        Postman
                                        Collection</a></li>
                                <li><a href="https://github.com/authy/authy-form-helpers">Authy Form Helpers</a></li>
                                <li><a href="https://github.com/AuthySE/Authy-demo">Github for this demo</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="verification/">
                                <input type="submit" value="Verify" class="btn btn-info btn-block">
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="register/">
                                <input type="submit" value="Authy 2FA" class="btn btn-info btn-block">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

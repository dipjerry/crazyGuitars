<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html>
<title>Crazy Guitars</title>
<meta charset="UTF-8">
<link rel="icon" href="./images/icon.ico" type="image/icon type">
<link rel="stylesheet" href="style/urls.css">
<link rel="stylesheet" href="style/ui.css">
<link rel="stylesheet" href="style/base.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.tiny.cloud/1/92ltn95nzfq205vfh547qcolol9ltoexruk64k9xtl8qc9zz/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea",
        plugins: ["emoticons"],
        menubar: false,
        statusbar: false,
        toolbar: "bold italic underline| alignleft aligncenter alignright alignjustify | bullist numlist | emoticons"
    });
</script>
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    a,
    a:active {
        font-family: "Raleway", sans-serif
    }

    body {
        overflow-y: hidden;
        overflow-x: hidden;
        scroll-behavior: smooth;
    }

    #form,
    .button {
        display: flex;
        justify-content: center;
    }

    textarea {
        resize: vertical;
    }

    .sideSocio {
        /* margin-top: 5%; */
        /* height: 100%; */
        padding: 5px;
    }

    .follow {
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    @media screen and (max-width: 600px) {
        .socio-btn {
            padding: 30% 0% 10% 0%;
            margin-top: 90%;
        }

        .sideSocio3 {
            margin-top: 90%;
        }
    }

    .sideSocio3 {
        padding: 70% 0% 90% 0%;
    }

    .socio:hover {
        cursor: pointer
    }

    .socio-btn {
        margin: 20% 0% 20% 0%;
    }

    #fb {
        color: #006fff;
        text-shadow: 0 0 30px #006fff;
    }

    #ln {
        color: #0e76a8;
        text-shadow: 0 0 30px #0e76a8;
    }

    #tw {
        color: #00acff;
        text-shadow: 0 0 30px #00acff;
    }

    #git {
        color: #eee;
        text-shadow: 0 0 30px #0eee;
    }

    .btn.fb-btn:hover {
        transform: scale(1.2);
        box-shadow: 0 30px 45px -15px rgba(0, 111, 255, 0.65);
    }

    .btn.ln-btn:hover {
        transform: scale(1.2);
        box-shadow: 0 30px 45px -15px rgba(255, 16, 39, 0.57);
    }

    .btn.tw-btn:hover {
        transform: scale(1.2);
        box-shadow: 0 30px 45px -15px rgba(0, 111, 255, 0.6);
    }

    .btn.git-btn:hover {
        transform: scale(1.2);
        box-shadow: 0 30px 45px -15px rgba(0, 111, 255, 0.6);
    }

    #success_message {
        margin-left: 20px;
        color: #189a18;
        display: none;
    }

    #error_message {
        margin-left: 20px;
        color: red;
        display: none;
    }

    footer {
        position: relative;
        left: 0;
        bottom: 0px;
        width: 100%;
    }
</style>

<body>
    <?php require('nav.php'); ?>
    <br><br>
    <div class="w3-row ">
        <div class="w3-col m12">
            <div class="w3-margin" id="form">
                <!-- <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Open Modal</button> -->
                <div class=" w3-card-4 w3-red w3-container w3-col m11 l4">
                    <form id="contact-form">
                        <h2 class="w3-center">Contact Us</h2>
                        <div id="success_message">
                            Comments Added Successfully!
                        </div>
                        <div id="error_message">
                            Comments cannot be Added
                        </div>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:50px">
                                <i class="w3-xxlarge fa fa-user"></i>
                            </div>
                            <div class="w3-rest">
                                <input type="text" id="name" name="name" class="w3-input" placeholder="Your name..">
                            </div>
                        </div>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:50px">
                                <i class="w3-xxlarge fa fa-envelope-o"></i>
                            </div>
                            <div class="w3-rest">
                                <input type="email" id="email" name="email" class="w3-input" placeholder="Your email..">
                            </div>
                        </div>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
                            <div class="w3-rest">
                                <textarea id="feedback" name="feedback" placeholder="Write something.." style="height:140px; width:100%"></textarea>
                            </div>
                        </div>
                        <div class="w3-margin button">
                            <input type="button" value="Submit" id="contact_submit" class="w3-btn w3-red">
                        </div>
                    </form>
                </div>
                <div class=" w3-black w3-center sideSocio w3-col m1 s1">
                    <div class="w3-row sideSocio3 w3-center">
                        <div class="w3-col  s12 socio-btn">
                            <span class="socio">
                                <i class="fa fa-facebook-f btn fb-btn" id="fb" style="font-size:24px"></i>
                            </span>
                        </div>
                        <div class="w3-col s12 socio-btn">
                            <span class="socio ">
                                <i class="fa fa-twitter btn tw-btn" id="tw" style="font-size:24px"></i>
                            </span>
                        </div>
                        <div class="w3-col s12 socio-btn">
                            <span class="socio ">
                                <i class="fa fa-linkedin btn ln-btn" id="ln" aria-hidden="true" style="font-size:24px"></i>
                            </span>
                        </div>

                        <div class="w3-col s12 socio-btn">
                            <span class="socio ">
                               <a href="https://github.com/dipjerry" target="_blank"> <i class="fa fa-github btn git-btn" id="git" aria-hidden="true" style="font-size:24px"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <div class="w3-container">
                    <span id="modal-hide" class="w3-button w3-display-topright">&times;</span>
                    <div>
                        <p>Thanks For Your Feedback</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function() {
                $(document).on('click', '#modal-hide', function() {
                    $("#id01").hide();
                });
            $(document).on('click', '#contact_submit', function() {
                // $("#comment-message-new").css('display', 'none');
                tinyMCE.triggerSave();
                var str = $("#contact-form").serialize();
                $.ajax({
                    url: "classes/functions.php",
                    data: str,
                    type: 'post',
                    success: function(response) {
                        var result = eval('(' + response + ')');
                        if (response) {
                    $("#id01").show();
                            $("#name").val("");
                            $("#email").val("");
                           tinyMCE.activeEditor.setContent('');
                        } else {
                            // $("#error-message").css('display', 'inline-block');
                            return false;
                        }
                    }
                });
            });
            });
        </script>
    </div>
    <?php
    require('footer.php');
    ?>
</body>

</html>
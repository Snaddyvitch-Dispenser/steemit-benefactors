<?php
$actual_link = isset($_SERVER['HTTPS']) ? "https" : "http";
$actual_link .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (!isset($_SESSION["randstring"])) {
    $_SESSION["randstring"] = "xres";
}
?>
<!DOCTYPE HTML>
<html>

<head>

    <title>Steemit 👏 Benefactors</title>
    <meta name="description" content="Steemit Beneficiaries is the best way to post on the steemit blockchain with tons of options! The 👏 future 👏 of 👏 steemit 👏 posting 👏 is 👏 here, 👏 now!"/>
    <meta name="keywords" content="steem,steemit,post,make,money,blockchain,delegation,benefactor,rewards,voting,split,share"/>
    <meta charset="utf-8"/>
    <meta lang="en"/>
    <meta name="author" content="Conor Howland (@cadawg)"/>
    <meta name="generator" content="@cadawg"/>
    <meta name="copyright" content="Copyright Conor Howland 2018"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?php include "icons.php"; ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat|Pacifico" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>
    <script src="consent.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/DavidG103/simpletooltips@1.3/release/tooltip.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/DavidG103/simpletooltips@1.3/release/tooltip.min.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

    <link type="text/css" rel="stylesheet" href="style.css"/>
</head>

<body>

<div id="wrapper">

    <div id="header">

        <div id="id">

            <p>Steemit<br>Benefactors</p>

        </div>
        <div id="nav">

            <ul>
                <li><a href="index.php">Write</a></li>
                <li><a href="logout.php?state=<?php echo $actual_link;?>">Logout</a></li>
                <li><a href="about.html">About</a></li>

        </div>

    </div>

    <div id="banner">

        <h1>Write Post, @<?php echo $_SESSION["user"]; ?></h1>
        <p>Now that you are logged in, write that epic post the the blockchain needs, but doesn't deserve! :)</p>
    </div>
    <div id="content">

        <form id="postform">
            <div>
                <label for="title">Title: *</label>
                <input required type="text" name="title" id="title">
            </div>
            <div>
                <label for="permlink" id="permlink-tt" data-tooltip-text="Last part of the link: https://steemit.com/category/ @<?php echo $_SESSION["user"]; ?>/permlink. Only alphanumeric and dashes">Permlink <em class="tooltippable">?</em>: *</label>
                <input required type="text" name="permlink" id="permlink">
            </div>
            <div>
                <label for="tags" id="tags-tt" data-tooltip-text="All lowercase, alphanumeric and dashes only, separated by commas, between 1 and 5. First one is category!">Tags <em class="tooltippable">?</em>: *</label>
                <input type="text" required name="tags" id="tags">
            </div>
            <div class="benefactors">
                <button class="add_form_field">Add New Benefactor &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button> <em class="tooltippable" id="benefactors-tt" data-tooltip-text="Users to split post rewards with! Max total of all percents is 95! Do not add percent symbol!">?</em>
                <button class="get_benefactor_url">Get Benefactor Url</button> <em class="tooltippable" id="rewardshare-tt" data-tooltip-text="Get current reward sharing settings as a shareable url!">?</em>
                <div class="wrappery">
                </div>
            </div>

            <label for="post">Your Post *:</label>
            <textarea class="w3-input" required title="Write your post here!" id="post" name="post"></textarea>

            <button id="subjs">Submit!</button>
        </form>

        <iframe data-aa='1007335' src='//ad.a-ads.com/1007335?size=728x90&background_color=222222&text_color=ffffff&title_color=ffffff&title_hover_color=aaaaff&link_color=ffffff&link_hover_color=aaaaff' scrolling='no' style='width:728px; height:90px; border:0px; padding:0;overflow:hidden' allowtransparency='true'></iframe>
        <a class="adtext" rel="nofollow" href='http://a-ads.com?partner=1007335'>Advertise Here</a>
    </div>

</div>

<script src="writepost.js"></script>

<script>
	$("#subjs").click(function(e) {
    e.preventDefault();
    var url = "submitpost.php?js"; // the script where you handle the form input.
	
	$("#subjs").prop("disabled",true);
	
    $.ajax({
        type: "POST",
        url: url,
        data: $("#postform").serialize(), // serializes the form's elements.
        success: function(data)
        {
			$("#subjs").prop("disabled",false);
            
            alert(data, "Steemit Benefactors", true);
        }

    });

    return false;
});

    var simplemd = new SimpleMDE({
        element: $("#post")[0],
        autosave: {
            enabled: true,
            delay: 10000,
            uniqueId: "post_content_<?php echo $_SESSION["randstring"]; ?>"
        },
        autoDownloadFontAwesome: true,
        placeholder: "Write your epic steemit post here!",
        forceSync: true
    });

    function alert(message = "", pagename = "This page", killPrev = false) {
        if (killPrev === true) {
            $(".fs-overlay").remove();
        }
        $("<div class='fs-overlay'><div class='midbox'><p>" + pagename +" says:</p>" + message + "<br><br><button class='chrome-alert' onclick='$(this).parent().parent().remove();'>OK</button></div></div>").appendTo("body");
    }

    function prompt(message = "", callback = "console.log", callbackFunction = console.log, uniqueID = "", buttonOK = "Yes", buttonCANCEL = "No", pagename = "This page", killPrev = false) {
        if (killPrev === true) {
            $(".fs-overlay").remove();
        }

        if (readCookie(uniqueID) == null) {
            $("<div class='fs-overlay'><div class='midbox'><p>" + pagename + " says:</p>" + message + "<br><br><button class='chrome-alert' onclick='" + callback + "(true);$(this).parent().parent().remove();'>" + buttonOK + "</button><button class='chrome-cancel' onclick='" + callback + "(false);$(this).parent().parent().remove();'>" + buttonCANCEL + "</button></div></div>").appendTo("body");
        } else {
            if (readCookie(uniqueID) == "true") {
                callbackFunction(true);
            } else {
                callbackFunction(false);
            }
        }
    }

    $(".get_benefactor_url").click(
        function(e){

            e.preventDefault();

            var url = "getBenefactorUrl.php"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#postform").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    alert("<p class='titl'>URL:</p><p>" + data + "</p><p class='titl'>Steemit Ready Link:</p><p>[Write On Steemit BF](" + data + ")</p><p class='titl'>Hyperlink:</p><p><a href='" + data + "'>Link</a></p>", "Steemit Benefactors", true);
                }
            });

            return false;
        }
    );

    $(document).ready(function() {
        var max_fields      = 20;
        var wrapper         = $(".wrappery");
        var add_button      = $(".add_form_field");

        <?php
        $benebox = explode(",",$_GET["bf"]);
        foreach($benebox as $ind=>$vali) {
        $val = explode(":",$vali);
        if (isset($val[1])) {?>
        $(wrapper).append('<div><input type="text" class="ddt" value="<?php echo $val[0]; ?>" placeholder="Username without @" name="ubenefactors[]"/><input type="tel" value="<?php echo $val[1]; ?>" class="ddt" placeholder="Percentage 0.01 - 95.00" name="vbenefactors[]"/><a href="#" class="delete">Delete</a></div>'); //add input box
        <?php }} ?>

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapper).append('<div><input type="text" class="ddt" placeholder="Username without @" name="ubenefactors[]"/><input type="tel" class="ddt" placeholder="Percentage 0.01 - 95.00" name="vbenefactors[]"/><a href="#" class="delete">Delete</a></div>'); //add input box
            }
            else
            {
                alert('Sorry, this is the limit!');
            }
        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>
<!--https://steem.ly/cdwg-->

<script>
    /*GDPR Compliance :(*/

    function injectTracking(should) {
        if (readCookie("gdprtracking") == null) {
            createCookie("gdprtracking", should, 31);
        }

        if(should) {

            var script=document.createElement('script');
            script.type='text/javascript';
            script.src= 'https://www.googletagmanager.com/gtag/js?id=UA-45168180-9';
            script.async = true;

            $("body").append(script);
            window.dataLayer=window.dataLayer || []; function gtag(){dataLayer.push(arguments);}gtag('js', new Date()); gtag('config', 'UA-45168180-9');
        }
    }

    prompt("<p>Allow us to run Analytics? 🙏</p>", "injectTracking", injectTracking, "gdprtracking");
</script>



</body>

</html>

<?php /*<form id="postform" action="submitpost.php" method="post" style="margin: 0 auto; text-align: center;" class="w3-container w3-card-4 w3-margin">

    <input type="text" name="benefactor" class="w3-input" style="width: 100%;" placeholder="cadawg:10.00,mermaidvampire:5.00,johndoer123:2.50,ned:12:74" value="<?php if(isset($_GET['bf'])) {echo $_GET['bf'];} ?>"><br><br>
    <p>Your Post *:</p>
    <textarea class="w3-input" required title="Write your post here!" id="post" style="width: 100%; height: 50ch;" name="post"></textarea>


    <div id="yourpost"></div>

    <!--<script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="g-recaptcha" data-sitekey="6Lf29lgUAAAAAGFJ33HRoDBGYrD3R3QqLEIs78dY"></div>-->

    <noscript><input type="submit" value="Submit!" class="w3-button w3-blue w3-round"> <br> If you see double submit buttons, don't worry! Either will work! <br></noscript><?php if(isset($_GET['htmlonly'])) { echo '<input type="submit" value="Submit!">'; } ?>
    <?php if(!isset($_GET['htmlonly'])) { ?> <button class="w3-button w3-blue w3-round" id="subjs" class="no-js">Submit!</button> <?php } ?>
    <div id="hyperholder"></div><br>
    <br><br>
</form>

</body>
<?php if(!isset($_GET['htmlonly'])) { ?>
    <script>
        $("#subjs").click(function() {

            var url = "submitpost.php?js"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#postform").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    var ds = data.split(":|:&*83252835723&&+£");
                    alert(ds[0]); // show response from the php script.
                    if (1 in ds) {
                        $("#hyperholder").html(ds[1]);
                    }

                }
            });

            return false;
        });
    </script>
    <style>
        .no-js {display: none;}
        .btnb {
            background-color: dodgerblue;
            border-radius: 5px;
            border: 10px solid dodgerblue;
        }
        .btnb:active {
            background-color: blue;
            border: 10px solid blue;
            border-radius: 5px;
            outline: none;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#subjs").removeClass("no-js");
        });

        var simplemd = new SimpleMDE({
            element: $("#post")[0],
            autosave: {
                enabled: true,
                delay: 10000,
                uniqueId: "post_content"
            },
            autoDownloadFontAwesome: true,
            placeholder: "Write your epic steemit post here!",
            forceSync: true
        });

        setInterval(function () {
            var markAble = "";
            $(".CodeMirror-line").each(function (index) {
                markAble = markAble + $($(".CodeMirror-line")[index]).text() + "\n";
            });
            document.getElementById('yourpost').innerHTML = simplemd.options.previewRender(markAble);
            $('#yourpost').find("code").addClass("w3-codespan ch-mono");
        }, 1000);
    </script>
<?php } ?>

<script>
    new tooltip(document.getElementById("permlink-tt"));
    new tooltip(document.getElementById("tags-tt"));
    new tooltip(document.getElementById("benefactors-tt"));
</script>

</html>*/
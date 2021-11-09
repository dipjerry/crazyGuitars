<!-- comment -->
<div class="comment-form-container">

    <form id="frm-comment-new">
        <div class="input-row">
            <input type="hidden" name="comment_id" id="commentId_new" />
            <input type="hidden" name="comment_post_id" value="<?php echo $row['postID']; ?>" id="commentPostId_new" />
            <input class="input-field" type="email" name="email" id="email_new" placeholder="Your Email *" autocomplete="on" required />
        </div>
        <div class="input-row">
            <input class="input-field" type="text" name="name" id="name_new" placeholder="Name" autocomplete="on" />
        </div>
        <div class="input-row">
            <textarea class="input-field" type="text" name="comment" id="comment_new" placeholder="Add a Comment *">  </textarea>
        </div>
        <div>
            <input type="button" class="btn-submit" id="submitButton_comment" value="Publish" />
            <div id="comment-message-new">Comments Added Successfully!</div>
            <div id="comment-error-new">Comments cannot be Added</div>
        </div>

    </form>
</div>
<div id="output"></div>









<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-reply', function() {
            var commentId = $(this).data("eid");
            var postId = $(this).data("pid");
            var form = "<form class='comment_reply' id='frm-comment'><div class = 'input-row'>" +
                "<input type = 'hidden' name = 'comment_id' value='" + commentId + "' id = 'commentId'/>" +
                "<input type = 'hidden' name = 'comment_post_id' value='" + postId + "' id = 'commentPostId'/>" +
                "<input class = 'input-field' type = 'email' name = 'email' id = 'email_reply' placeholder = 'Email' autocomplete='on' required/> " +
                "</div><div class='input-row'>" +
                "<input class = 'input-field' type = 'text' name = 'name' id = 'name' placeholder = 'Name'/> " +
                "</div> <div class = 'input-row'>" +
                "<textarea class = 'input-field' type = 'text' name = 'comment' id = 'comment' placeholder = 'Add a Comment'> </textarea>" +
                "</div > <div ><button type = 'button' class = 'btn-submit' id = 'submitButton' >Publish</button>" +
                "<div id = 'comment-message' > Comments Added Successfully! < /div> </div>" +
                "</form>";
            var closestDiv = $(this).closest('div'); // also you can use $(this).parent();
            // $('.comment_reply').not(closestDiv.next('.comment_reply fieldset')).hide();
            $('.comment_reply').not(closestDiv.next('.comment_reply')).remove();
            // $('.comment_reply').not(closestDiv.next('.comment_reply')).children().attr("disabled", "disabled");
            // $('.comment_reply').not(closestDiv.next('.comment_reply input[type="submit"]')).prop("disabled", true);
            closestDiv.next('div').append(form);
            $("#email_reply").focus();
        });
    });



    $(document).on('click', '#submitButton', function() {
        // alert("groot");
        $("#comment-message").css('display', 'none');
        tinyMCE.triggerSave();
        var str = $("#frm-comment").serialize();

        // alert(str);
        $.ajax({
            url: "classes/comment-add.php",
            data: str,
            type: 'post',
            success: function(response) {
                var result = eval('(' + response + ')');
                if (response) {
                    $("#comment-message").css('display', 'inline-block');
                    $("#name").val("");
                    $("#email").val("");
                    $("#comment").val("");
                    $("#commentId").val("");
                    $("#commentPostId").val("");
                    listComment();
                } else {
                    alert("Failed to add comments !");
                    return false;
                }
            }
        });
    });
    $(document).on('click', '#submitButton_comment', function() {
        // alert("groot");
        $("#comment-message-new").css('display', 'none');
        tinyMCE.triggerSave();
        var str = $("#frm-comment-new").serialize();

        // alert(str);
        $.ajax({
            url: "classes/comment-add.php",
            data: str,
            type: 'post',
            success: function(response) {
                var result = eval('(' + response + ')');
                // alert("result");
                if (response) {
                    // alert("guu2");
                    $("#comment-message-new").css('display', 'inline-block');
                    $("#name_new").val("");
                    $("#email_new").val("");
                    $("#comment_new").val("");
                    $("#commentId_new").val("");
                    $("#commentPostId_new").val("");
                    listComment();
                    // alert("ok");
                } else {
                    // alert("guu");
                    $("#comment-message-new").css('display', 'inline-block');
                    return false;
                }
            }
        });
    });

    $(document).ready(function() {
        listComment();
    });

    function listComment() {
        var post_id = $("#commentPostId_new").val();
        // alert(post_id);
        $.post("classes/comment-list.php", {
                post_id: post_id
            },
            function(data) {
                var data = JSON.parse(data);

                var comments = "";
                var replies = "";
                var item = "";
                var parent = -1;
                var results = new Array();

                var list = $("<ul class='outer-comment'>");
                var item = $("<li>").html(comments);

                for (var i = 0;
                    (i < data.length); i++) {
                    var commentId = data[i]['comment_id'];
                    var commentPostId = data[i]['post_id'];
                    parent = data[i]['parent_comment_id'];
                    sender_name = data[i]['comment_sender_name'];
                    if (sender_name == '') {
                        commenter_name = 'Annonymous';
                    } else {
                        commenter_name = sender_name;
                    }
                    if (parent == "0") {
                        comments = "<div class='comment-row'>" +
                            "<div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" +
                            commenter_name + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['date'] + "</span></div>" +
                            "<div class='comment-text'>" + data[i]['comment'] + "</div>" +
                            "</div><div><button class='btn-reply' data-eid='" + commentId + "' data-pid='" + commentPostId + "'>Reply</button></div><div></div>";
                        var item = $("<li>").html(comments);
                        list.append(item);
                        var reply_list = $('<ul>');
                        item.append(reply_list);
                        listReplies(commentId, data, reply_list);
                    }
                }
                $("#output").html(list);
            });
    }

    function listReplies(commentId, data, list) {
        for (var i = 0;
            (i < data.length); i++) {
            if (commentId == data[i].parent_comment_id) {
                sender_name = data[i]['comment_sender_name'];
                if (sender_name == '') {
                    commenter_name = 'Annonymous';
                } else {
                    commenter_name = sender_name;
                }
                var comments = "<div class='comment-row'>" +
                    " <div class='comment-info'><span class='commet-row-label'>from</span> <span class='posted-by'>" + commenter_name + " </span> <span class='commet-row-label'>at</span> <span class='posted-at'>" + data[i]['date'] + "</span></div>" +
                    "<div class='comment-text'>" + data[i]['comment'] + "</div>" +

                    "</div>" +
                    "<div><button class='btn-reply' data-eid='" + data[i]['comment_id'] + "'>Reply</button></div><div></div>";
                // "<form class='comment_reply' id='frm-comment'><fieldset class='mainFieldset'> <div class = 'input-row'>" +
                // "<input type = 'hidden' name = 'comment_id' value=" + data[i]['comment_id'] + " id = 'commentId' placeholder = 'Name'/>" +
                // "<input class = 'input-field' type = 'text' name = 'name' id = 'name' placeholder = 'Name'/> " +
                // "</div> <div class = 'input-row'>" +
                // "<textarea class = 'input-field' type = 'text' name = 'comment' id = 'comment' placeholder = 'Add a Comment'> </textarea>" +
                // "</div > <div ><button type = 'button'class = 'btn-submit' id = 'submitButton' >Publish</button>" +
                // "<div id = 'comment-message' > Comments Added Successfully! < /div> </div>" +
                // "</fieldset></form>";
                var item = $("<li>").html(comments);
                var reply_list = $('<ul>');
                list.append(item);
                item.append(reply_list);
                listReplies(data[i].comment_id, data, reply_list);
            }
        }
    }
</script>
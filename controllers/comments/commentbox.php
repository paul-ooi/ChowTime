<?php include '../../pages/partial/_header.php'; ?>
</head>

<section id="commentBox">
        <h2>Add Comment</h2>
        <form action="" method="post" id="addComment">
            <div>
                <textarea class="form-control" rows="4"></textarea>
            </div>
            <div>
                <form action="" method="post" name="addComment">
                    <input type="hidden" value="<?php // Event Id ?>" />
                    <input type="submit" class="btn btn-default" id="comSub" value="Submit" />
                </form>
            </div>
        </form>
</section>

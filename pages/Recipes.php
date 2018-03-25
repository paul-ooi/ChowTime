<?php $pageTitle = "Recipes"; include '_header.php'; ?>
    </header>
    <main>
        <div class="aside-left">
            <div class="image-container">
                <img src="#" alt="image" id="main"/>
                <div class="thumbnail-image-container">
                    <img src="#" alt="thumbnail" class="thumbnail" />
                    <img src="#" alt="thumbnail" class="thumbnail" />
                    <img src="#" alt="thumbnail" class="thumbnail" />
                    <img src="#" alt="thumbnail" class="thumbnail" />
                    <img src="#" alt="thumbnail" class="thumbnail" />
                </div>
            </div>
        </div>
        <div class="aside-right">
            <div class="title-icon-descr-container">
                <h2>Recipe Title</h2>
                <div class="icon-container">
                    <div class="icon-text-container">
                        <img src="#" alt="icon" class="icon" />
                        <p>Difficulty</p>
                    </div>
                    <div class="icon-text-container">
                        <img src="#" alt="icon" class="icon" />
                        <p>Total Time</p>
                    </div>
                    <div class="icon-text-container">
                        <img src="#" alt="icon" class="icon" />
                        <p>Community Rating</p>
                    </div>
                    <div class="icon-text-container">
                        <img src="#" alt="#" class="icon" />
                        <p>Recommended Rating</p>
                    </div>
                    <div class="icon-text-container">
                        <img src="#" alt="#" class="icon" />
                        <p>Spicy Level</p>
                    </div>
                </div>
                <p>Description of Recipe</p>
            </div>
            <div class="ingredients-container">
                <h2>ingredients</h2>
                <span>Prep Time</span>
                <div class="ingredient-container">
                    <span>Quantity</span>
                    <span>Unit</span>
                    <span>food item id</span>
                </div> <!-- Repeat this ingredient-container block for each ingredient in the list -->
            </div>

            <div class="directions-container">
                <h2>Directions</h2>
                <span>Cook Time</span>
                <div class="direction-container">
                    <p>Directions Array</p>
                </div>
            </div>
        </div> <!-- End aside right -->
        <div class="comment-container">
            <form action="Recipes.php" method="post">
                <label for="comments">Comments</label>
                <textarea name="comments" id="comments"></textarea>
                <input type="submit" id="addComment" name="addComment" /> 
            </form>
        </div>
    </main>
<?php include '_footer.php'; ?>
</body>
</html>

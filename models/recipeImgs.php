<?php
class RecipeImages {

    private $id;
    private $recipe_id;
    private $img_src;
    private $theme_id;

    //GETTERS
    public function getId() {
        return $this->id;
    }
    public function getRecipeId() {
        return $this->recipe_id;
    }
    public function getImgSrc() {
        return $this->img_src;
    }
    public function getThemeId() {
        return $this->theme_id;
    }

    // SETTERS
    public function setId($in_id) {
        $this->id = $param;
    }
    public function setRecipeId($in_rId) {
        $this->recipe_id = $in_rId;
    }
    public function setImgSrc($in_img) {
        $this->img_src = $in_img;
    }
    public function setThemeId($in_themeId) {
        $this->theme_id = $in_themeId;
    }

    public function __construct($id, $recipedId, $imgSrc, $themeId) {
        $this->setId($id);
        $this->setRecipeId($recipedId);
        $this->setImgSrc($imgSrc);
        $this->setThemeId($themeId);
    }
}

 ?>

<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 05.06.17
 * Time: 10:46
 */

namespace App\Presenters;


class PostPresenter extends Presenter
{
    public function author()
    {
        return $this->entity->author->display_name;
    }

    public function date()
    {
        return $this->formatDate($this->entity->post_date);
    }

    public function title()
    {
        return $this->entity->post_title;
    }

    public function content()
    {
        return $this->entity->post_content;
    }

}
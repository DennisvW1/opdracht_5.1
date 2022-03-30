<?php

class Footer implements IShowContent
{
    public function showContent()
    {
        echo"<footer class='footer mt-auto py-3 bg-dark'>
        <div class='container'>
            <span class='text-muted'>&copy;".date("Y")."&nbsp;Dennis van Willigen</span>
        </div>
        </footer>";
    }
}
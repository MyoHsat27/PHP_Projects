<?php
if (hasSession('error')) {
    echo "<div class='session-container container'>
    <div class='bg-danger'>".getSession('error')."</div>
</div>";
} elseif (hasSession()) {
    echo "<div class='session-container container'>
    <div>".getSession()."</div>
</div>";
}



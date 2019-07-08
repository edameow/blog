    <div class="row">
        <div class="col-md-12">
            <ul class="profile-view">
                <li>
                    <?php if ($user->image) {?>
                        <img src="/images/avatar/<?= $user->image ?>" class="profile-avatar">
                    <?php } else {?>
                        <img src="/images/avatar/empty.png" class="profile-avatar">
                    <?php }?>
                </li>
                <li>
                    <b>Описание:</b> <?= $user->description ?>
                </li>
                <li>
                    <b>Имя:</b> <?= $user->name ?>
                </li>
                <li>
                    <b>Почта:</b> <?= $user->email ?>
                </li>
            </ul>
        </div>
    </div>

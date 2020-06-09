<?php
$db = new DB();
$notfications = $db->findNull('notifications', 'read_at', false);
$config = config();
$user = $db->find('users','id',$_SESSION['id']);
?>
<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="/panel/index.php" class="logo"><img src="<?php echo !empty($config->logo) ? pathImage($config->logo) : ''?>" height="50" alt="logo" width="150"></a>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-bell-outline noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge"><?php echo count($notfications); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5><?php echo "اعلان ها ".count($notfications); ?></h5>
                    </div>

                    <div class="slimscroll-noti">
                        <!-- item-->
                        <?php

                            foreach ($notfications as $notifi):
                                if($notifi->type == 'contacts'):
                                    $contact = json_decode($notifi->data)->data;
                        ?>
                                    <a href="/photograph/panel/contact/index.php" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b><?php echo $contact->username; ?></b><span class="text-muted"><?php echo $contact->subject; ?></span></p>
                                    </a>
                        <?php
                                endif;
                            endforeach;
                        ?>

                    </div>

                </div>
            </li>


            <li class="list-inline-item dropdown notification-list nav-user">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo !empty($user->image) ? pathImage($user->image) : '/photograph/assets/images/userImage.png'; ?>" alt="user" class="rounded-circle">
                    <span class="d-none d-md-inline-block ml-1"><?php echo $user->username; ?> <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <?php if(ACL::manager()): ?>
                    <a class="dropdown-item" href="/photograph/panel/config/index.php"><i class="mdi mdi-settings"></i> کانفیگ سایت</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="/photograph/panel/userinfo/update.php/<?php echo $_SESSION['id']; ?>"><i class="dripicons-user text-muted"></i> ویرایش اطلاعات کاربری</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../backEnd/functions/backEndFunctions/logout.php"><i class="dripicons-exit text-muted"></i> خروج</a>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="list-inline-item">
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
            <li class="list-inline-item dropdown notification-list d-none d-sm-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    ایجاد جدید <i class="mdi mdi-plus"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated">
                    <a class="dropdown-item" href="/photograph/panel/category/create.php">دسته</a>
                    <a class="dropdown-item" href="/photograph/panel/gallery/create.php">گالری</a>
                    <a class="dropdown-item" href="/photograph/panel/user/create.php">کاربر</a>
                </div>
            </li>

        </ul>


    </nav>

</div>
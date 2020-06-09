<!-- ========== Left Sidebar Start ========== -->
<?php
$db = new DB();
$contact = $db->where('notifications','`type`="contacts" AND ISNULL(`read_at`)');
?>
<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="mdi mdi-close"></i>
    </button>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="/photograph/panel/index.php" class="waves-effect">
                        <i class="dripicons-home"></i>
                        <span> داشبرد </span>
                    </a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cubes"></i> <span> دسته بندی </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/photograph/panel/category/category.php">لیست دسته ها</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-image-album"></i> <span> گالری </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/photograph/panel/gallery/index.php">لیست تصاویر</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-worker"></i> <span> همکار ها </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/photograph/panel/partner/index.php">لیست همکارها</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i> <span> تنظیمات </span> <span class="badge badge-info badge-pill float-right"><?php echo count($contact); ?></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/photograph/panel/service/index.php">سرویس ها</a></li>
                        <li><a href="/photograph/panel/about/index.php">درباره ما</a></li>
                        <li><a href="/photograph/panel/contact/index.php"> تماس با ما<span class="badge badge-danger badge-pill float-right"><?php echo count($contact); ?></span></a></li>
                    </ul>
                </li>
                <?php if(ACL::manager()): ?>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> کاربران </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="/photograph/panel/user/index.php">لیست کاربران</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
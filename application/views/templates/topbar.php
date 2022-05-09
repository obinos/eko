<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="butt" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg> </a>
                <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                    <div class="form-group">
                        <input type="text" placeholder="Search user..." class="form-control" name="top-search" id="top-search" autocomplete="off">
                    </div>
                </form> -->
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle text-primary" href="#"><?= $this->session->userdata('name') ?><svg class="mx-2" style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                        </svg></a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="logout-button dropdown-item" href="<?= base_url('auth/logout'); ?>">
                                <svg class="mr-2 rotate90" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                </svg> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <div class="row wrapper border-bottom bg-white page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>profile">
                        <?php if ($this->uri->segment(1) == "dashboard") {
                            echo "<strong>Home</strong>";
                        } else {
                            echo "Home";
                        } ?>
                    </a>
                </li>
                <?php if ($this->uri->segment(1) != "dashboard") { ?>
                    <li class="breadcrumb-item">
                        <a href="<?php if (!$this->uri->segment(2)) {
                                        echo base_url($this->uri->segment(1));
                                    } else {
                                        echo '#';
                                    } ?>">
                            <?php if (!$this->uri->segment(2)) {
                                echo "<strong>" . ucwords($this->uri->segment(1)) . "</strong>";
                            } else {
                                echo ucwords($this->uri->segment(1));
                            } ?></a>
                    </li>
                <?php } ?>
                <?php if ($this->uri->segment(2)) { ?>
                    <li class="breadcrumb-item active">
                        <strong><?php $uri = $this->uri->segment(2);
                                $uri2 = str_replace("_", " ", $uri);
                                echo ucwords($uri2); ?></strong>
                    </li>
                <?php } ?>
            </ol>
        </div>
    </div>
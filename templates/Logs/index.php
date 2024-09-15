<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Log> $logs
 */
?>
<?= $this->Html->css(['logs']) ?>
<main>
<div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Activity Logs') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Activity Logs'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
        </nav>

        <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
</main>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
<div class="container">
<!-- page content -->
<div class="py-6">
  <div class="row">
    <div class="offset-lg-1 col-lg-10 col-md-12 col-12">
      <!-- row -->
      <div class="row align-items-center mb-6">
        <div class="col-lg-6 col-md-12 col-12">
          <!-- form -->
          <form class="search" method="get" action="">
            <input type="text" class="form-control" id="Keyword" name="message" placeholder="Search Your Activity" value="<?= $this->request->getQuery('message') ?>">

        </div>
        <div class="col-lg-6 col-md-12 col-12 d-flex justify-content-end">
                <div class='mr-2'>
                    <button  class="btn btn-outline-secondary">
                    <a href="<?= $this->Url->buildFromPath('Logs::index') ?>" class="navbar-brand" style="white-space: normal;">
                        <i class="fa-solid fa-xmark"></i>
                        <?= __('Clear') ?>
                    </a>
                    </button>

                </div>
                <div>
                    <button type="submit" class="btn btn-outline-info">
                        <i class="fa fa-search"></i>
                        <?= __('Search') ?>
                    </button>
                </div>

        </div>
        </form>
      </div>
      <!-- hr -->

      <div class="mb-8">
        <!-- card -->
        <div class="card bg-gray-300 shadow-none mb-4">
          <!-- card body -->
          <div class="card-body">
            <div class="d-flex justify-content-between
              align-items-center">
              <div>
                <h5 class="mb-0">Activity Logs</h5>
              </div>
            </div>
          </div>
        </div>
        <!-- card -->
        <div class="card">
          <!-- list group -->
          <ul class="list-group list-group-flush">
            <!-- list group item -->
            <?php foreach ($logs as $log): ?>
            <div class="list-group-item p-3">
            <div class="row align-items-center">
                <!-- Action Icon Column -->
                <div class="col-auto text-muted">
                    <img src="<?=$this->Url->build("/img/action/".$log->action."icon.png");?>" alt="Action Icon" class="rounded-circle" style="width: 25px; height: 25px;"> By
                </div>
                <!-- User Avatar Column -->
                <div class="col-auto">
                    <a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'view', $log->user_id])?>">
                        <img src="<?=$this->Url->build($log->user->avatarimg??"/img/default_avatar.png");?>" width="50px" height="50px" class="rounded-circle">
                    </a>
                </div>

                <!-- Log Message Column -->
                <div class="col">
                    <p class="mb-0 font-weight-medium">
                        <a href="<?=$this->Url->build(['controller' => 'Users', 'action' => 'view', $log->user_id])?>">
                            <?=$log->user->f_name??"Unknown"?>
                        </a> 
                        <?= h($log->message) ?>
                    </p>
                </div>
                <!-- Timestamp Column -->
                <div class="col-auto text-muted">
                    <p class="mb-0 font-weight-medium">
                        <?php echo date('d-m-y H:i', strtotime($log->createtime));?>
                    </p>
                </div>
            </div>

            </div>

            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>




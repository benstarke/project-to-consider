<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContentBlocks\Model\Entity\ContentBlock> $contentBlocksGrouped
 */

$this->assign('title', 'Content Blocks');

$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);

$slugify = function($text) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
}
?>
<div class="">
    <nav class="bg-light d-flex justify-content-between align-items-center">
        <div class="ml-5 mr-3">
            <h3 class='text-primary'><?= __('System Settings') ?></h3>
            <ol class="breadcrumb" style="margin: 0;">
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="text-info" style="text-decoration: none;">Dashboard</a></li>
                <?php foreach(array_keys($contentBlocksGrouped) as $parent) {

                    // Titles
                    if ($parent === "Global") {
                        $parent = "General Branding";
                    } elseif ($parent === "Footer") {
                        $parent = "Footer & Copyright";
                    } elseif ($parent === "Email") {
                        $parent = "Email";
                    }

                    ?>
                    <li class="breadcrumb-item"><a href="#<?= $slugify($parent) ?>" class="text-info"><?= $parent ?></a></li>
                <?php } ?>
            </ol>
            <div>
            </div>
        </div>

    </nav>
</div>
<div class="contentBlocks index content" style="margin-left: 20px;">

    <?php
    /*
    // TODO: Think of a way to allow this for developers, but not for the actual website. Adding a content block doesn't
    //       mean anything for end users - it needs to be hard coded into a template somewhere to make sense. Perhaps
    //       it can just be guarded behind a DEBUG flag with an appropriate confirm() dialog warning that it needs to
    //       be used in a template after being added...
    echo $this->Html->link(__('New Content Block'), ['action' => 'add'], ['class' => 'button button-outline float-right'])
    */
    ?>

    <?php foreach($contentBlocksGrouped as $parent => $contentBlocks) { ?>

        <h4 class="content-blocks--list-subheading">

            <!-- Titles -->
            <?php
            if ($parent === "Global") {
                $parent = "General Branding";
            } elseif ($parent === "Footer") {
                $parent = "Footer & Copyright";
            }  elseif ($parent === "Email") {
                $parent = "Email";
            }
            ?>

            <a href="#<?= $slugify($parent)?>" id="<?= $slugify($parent)?>" style="text-decoration: none; color: #1c294e; font-weight: bold;">
                <?=  $parent ?>
            </a>

        </h4>

        <ul class="content-blocks--list-group">
            <?php foreach($contentBlocks as $contentBlock) { ?>
                <li class="content-blocks--list-group-item">
                    <div class="content-blocks--text">
                        <div class="content-blocks--display-name">
                            <?= $contentBlock['label'] ?>
                        </div>
                        <div class="content-blocks--description">
                            <?= $contentBlock['description'] ?>
                        </div>
                        <br>
                        <div class="content-blocks--current">

                            <!-- Preview of current logo/text/image -->
                            <?php
                            if ($contentBlock->type === 'text' || $contentBlock->type === 'html') {
                                if ($contentBlock->value) {
                                    echo '<div style="background-color: #ffffff; padding: 10px; border-radius: 5px; width: 75%;"><span>' . nl2br(html_entity_decode($contentBlock->value)) . '</span></div>';
                                }
                            } else if ($contentBlock->type === 'image') {
                                if ($contentBlock->value) {
                                    echo $this->Html->image($contentBlock->value, ['class' => 'content-blocks--image-preview']);
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <div class="content-blocks--actions">
                        <div class="d-flex justify-content-end">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentBlock->id], ['class' => 'button btn btn-outline-info mr-2']) ?>
                        </div>
                        <div class="mt-2 d-flex justify-content-end">
                            <?php if (!empty($contentBlock->previous_value)) echo $this->Form->postLink(__('Restore'), ['action' => 'restore', $contentBlock->id],
                                ['confirm' => __("Are you sure you want to restore the previous version for this item?\nNote: You cannot cancel this action!",
                                    $contentBlock->parent, $contentBlock->slug), 'class' => 'btn btn-outline-danger'
                                ])
                            ?>
                        </div>
                    </div>

                </li>
            <?php } ?>
        </ul>

    <?php } ?>

</div>
<?php
/**
 * Reset Password HTML email template
 *
 * @var \App\View\AppView $this
 * @var string $first_name email recipient's first name
 * @var string $last_name email recipient's last name
 * @var string $email email recipient's email address
 * @var string $nonce nonce used to reset the password
 */
?>
<div class="content">
    <!-- START CENTERED WHITE CONTAINER -->
    <table role="presentation" class="main">
        <!-- START MAIN CONTENT AREA -->
        <tr>
            <td class="wrapper">

                <?= $email_content ?>
                <br>
                
                <tr>
                    <td><a href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'newPassword', $nonce], ['fullBase' => true]) ?>" target="_blank">Set your password</a></td>
                </tr>
                <tr>
                <? $nonce ?>
                </tr>
            </td>
        </tr>
        <!-- END MAIN CONTENT AREA -->
    </table>
    <!-- END CENTERED WHITE CONTAINER -->
    <!-- START FOOTER -->
    <div class="footer" style="margin-top: 20px;">

        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
            <tr>
<td></td>
<td></td>
                <td class="content-block">
                    <?= $email_footer ?>
                </td>
                <br>
            </tr>
        </table>
    </div>
    <!-- END FOOTER -->
</div>

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
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h3>Reset your account password</h3>
                            <p>Hi <?= $first_name ?>, </p>
                            <p>Thank you for your request to reset the password of your account on <b>ClockwWork</b>. </p>
                            <p></p>
                            <p>To reset your account password, use the button below to access the reset password page: </p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td><a href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'resetPassword', $nonce], ['fullBase' => true]) ?>" target="_blank">Reset password</a></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
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
                    This emai is addressed to <?= email ?> may contain material that is confidential, for the sole use of the intended recipient. Any review, reliance or distribution by others or forwarding without express permission is strictly prohibited. If you are not the intended recipient or think this email has been sent in error, please delete all copies and contact the sender.
                    <br>
                    Please consider the environment before printing this email.
                </td>
                <br>
            </tr>
        </table>
    </div>
    <!-- END FOOTER -->
</div>

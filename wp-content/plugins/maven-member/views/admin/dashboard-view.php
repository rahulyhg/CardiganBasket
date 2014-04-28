    <div id="poststuff" class="metabox-holder has-right-sidebar" >
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class="hndle"><span> <?php _e("Status",maven_translation_key()); ?> </span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Registration enabled",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <?php if ($registration_enabled): ?>
                                            <img src="<?php echo $plugin_url . 'images/checked_green.png' ?>" alt="" />
                                        <?php else: ?>
                                            <img src="<?php echo $plugin_url . 'images/cancel.png' ?>" alt="" />
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Registration successful page",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <?php if ($registration): ?>
											<a target="_blank" href="<?php echo $registration ?>"><img src="<?php echo $plugin_url . 'images/checked_green.png' ?>" alt="" /> <?php _e("Page",maven_translation_key()); ?> </a>
                                        <?php else: ?>
                                            <img src="<?php echo $plugin_url . 'images/cancel.png' ?>" alt="<?php _e("Cancel",maven_translation_key()); ?>" />
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Enable auto-log out",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <?php if ($auto_logout_enabled): ?>
                                            <img src="<?php echo $plugin_url . 'images/checked_green.png' ?>" alt="checked" />
                                        <?php else: ?>
                                            <img src="<?php echo $plugin_url . 'images/cancel.png' ?>" alt="cancel" />
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Idle time limit",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <?php if ($auto_logout_limit): ?>
											<label ><?php echo $auto_logout_limit ?></label> <?php _e("(minutes)",maven_translation_key()); ?>
                                        <?php else: ?>
                                            <img src="<?php echo $plugin_url . 'images/cancel.png' ?>" alt="cancel" />
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
                
                <div class="postbox">
                    <h3 class="hndle"><span> <?php _e("I need your help!",maven_translation_key()); ?> </span></h3>
                    
                    <div class="inside">
                        <p><?php _e("Please, send me your feedback so I can improve the plugin!",maven_translation_key()); ?> <br/>
                            <?php _e('It just sents an email to <a href="mailto:mavenmember@gmail.com" >mavenmember@gmail.com</a>, please add an email account if you want me to answer you, or you can use the <a href="http://wordpress.org/tags/maven-member#postform" target="_blank" >Forum</a> to make your questions',maven_translation_key()); ?><br/>
                        </p>
                        
                        <form method="post">
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Your Email",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <input class="form-input-tip"  id="maven-email" name="maven-email"  />
                                        <?php _e("I'll use it to response your emails.",maven_translation_key()); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label ><?php _e("Question",maven_translation_key()); ?></label>
                                    </th>
                                    <td>
                                        <textarea  class="large-text code" rows="5" cols="50" id="maven-message" name="maven-message"  ></textarea>
                                    </td>
                                </tr>
                               
                        </table>
                        <div id="message" class="updated below-h2" style="<?php echo $thanks_message ?>">
                            <p><?php _e("Thanks! Your question will be answer soon!",maven_translation_key()); ?></p>
                        </div>
                        <p>
                            <?php _e("The question will be posted into the forum, without any information about where it comes from.",maven_translation_key()); ?>
                        </p>
                        <p class="submit">
                            <input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e("Send",maven_translation_key()); ?>"/>
                        </p>
                        </form>
                    </div>
            </div>
        </div>
    </div>
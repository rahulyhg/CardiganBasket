    <div id="poststuff" class="metabox-holder has-right-sidebar" >
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class="hndle"><span> <?php _e("FAQs",maven_translation_key()); ?> </span></h3>
                    <div class="inside">
                        <ol id="faqs">
                            <li>
                                <label >How can I block a post?</label>
                                    
                                <ol style="list-style-type: lower-alpha;">
                                    <li>
                                        You can protect a category (if the post is asociate to it). It means you can go to MVN Menu -> Categories, and assign a role to that category. So, if someone try to see any post under that category, a login will be required. And just users with that role will be able to see that posts. <br/>
                                    </li>
                                    <li>
                                        You can protect a post editing it in the wordpress editing posts, and selecting a role.
                                    </li>
                                </ol>
                                
                            </li> 
                            <li>
                                 <label >How can I block a page?</label>
                                 <ul>
                                    <li>
                                        You can protect a page editing it in the wordpress editing pages, and selecting a role.
                                    </li>
                                </ul>
                            </li>
                             <li>
                                <label >How can I block just a peace of content in a post?</label>
                                    
                                <ol style="list-style-type: lower-alpha;">
                                    <li>
                                        Once you have a role created, you can wrap the peace of content you want to create using <b>[mvn-block roles="your-role-id"] My protected content [/mvn-block] </b>
                                    </li>
                                   
                                </ol>
                                
                            </li> 
                            <li>
                                 <label >How can I show the registration form in a page?</label>
                                 <ul>
                                    <li>
                                        Easy, you can use the shortcode  [mvn-registration].
                                    </li>
                                </ul>
                            </li>
                           <li>
                                 <label >How can I show the login form in a page?</label>
                                 <ul>
                                    <li>
                                        Easy, you can use the shortcode  [mvn-login].
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <label >"Registration is not enabled" </label>
                                 <ul>
                                    <li>
                                        You can turn on/off the registration form. If you see that message, it's because you have turned off the registration. Go to Settings -> Registration to enable it.
                                    </li>
                                </ul>
                            </li>
                             <li>
                                <label > Want to add custom fields in the registration form? </label>
                                 <ul>
                                    <li>
                                        Easy! You can click on Maven Member -> Registration Fields -> Add new. Easy right? :)
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


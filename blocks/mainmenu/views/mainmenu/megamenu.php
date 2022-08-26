<?php
    global $tmpl; 
    $tmpl -> addScript('megamenu','blocks/mainmenu/assets/js');
    $tmpl -> addStylesheet('styles','blocks/mainmenu/assets/css');
    $lang = FSInput::get('lang');
    $Itemid = FSInput::get('Itemid');
?>

<ul id = 'megamenu' class="navbar-nav mr-auto mt-2 mt-lg-0">
		<?php $i = 0;?>
		<?php foreach($level_0 as $key=> $item):?>
			<?php $link = $item -> link? FSRoute::_($item -> link):''; ?>
			<?php $class = 'level_0';?>
			<?php $class .= $item -> description ? ' long ': ' sort' ?>
			<?php if($arr_activated[$item->id]) $class .= ' activated ';?>

			<li class="nav-item <?php if($key==0)echo 'first_li'?>" >
				<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="nav-link" title="<?php echo htmlspecialchars($item -> name);?>">
					<?php echo $item -> name;?>
				</a>
    				<!--	LEVEL 1			-->
    				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
                        <ul>
        				<?php }?>
        				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
        					<?php $j = 0;?>
        					<?php foreach($children[$item -> id] as $key=>$child){?>
        						<?php $link = $child -> link? FSRoute::_($child -> link):''; ?>
        						<li class='sub-menu-level1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
        							<a href="<?php echo $link; ?>" class="sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>">
                                        <?php echo $child -> name;?>
        		   		            </a>
                                    <!--	LEVEL 2			-->
                                    <?php if(isset($children[$child -> id]) && count($children[$child -> id])  ){?>
                                        <span class="click-show-menu" data-id='<?php echo $child->id ?>'>&nbsp;</span>
                                        <ul id="<?php echo $child->id ?>" class="level-3">
                                            <?php foreach($children[$child -> id] as $key=>$child2){?>
                                                <?php $link2 = $child2 -> link? FSRoute::_($child2 -> link):''; ?>
                                                <li class='sub-menu-level<?php echo $child2->level;?> <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
                                                    <?php if($link2==''){?>
                                                        <span class="<?php echo $class?> sub-menu-item span-child" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child2 -> name);?>">
                                                            <?php echo $child2 -> name;?>
                                                        </span>
                                                    <?php }else{?>
                                                        <a href="<?php echo FSRoute::_($link2); ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child2 -> name);?>">
                                                            <?php echo $child2 -> name;?>
                                                        </a>
                                                    <?php }?>
                                                    <!--	LEVEL 3			-->
                                                    <?php if(isset($children[$child2 -> id]) && count($children[$child2 -> id])){?>
                                                        <ul id="<?php echo $child2->id ?>" class="level-4">
                                                            <?php foreach($children[$child2 -> id] as $key=>$child3){?>
                                                                <?php $link3 = $child3 -> link? FSRoute::_($child3 -> link):''; ?>
                                                                <li class='sub-menu-level<?php echo $child3->level;?> <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
                                                                    <a href="<?php echo FSRoute::_($link3); ?>" class="<?php echo $class?> sub-menu-item" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child3 -> name);?>">
                                                                        <?php echo $child3 -> name;?>
                                                                    </a>
                                                                </li>
                                                            <?php }?>
                                                        </ul>
                                                    <?php }?>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    <?php }?>
        						</li>
        						<?php $j++;?>
        					<?php }?>
        				<?php }?>
        				<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
    				    </ul>   
    				<?php }?>
			</li>	
			<?php $i ++; ?>	
		<?php endforeach;?>
		<!--	CHILDREN				-->
	</ul>

<!-- Leadership Messages Section -->
<section>
    <div class="container">
        <div class="section-header">
            <h2>Message from Our Leadership</h2>
            <p>Words of wisdom from our esteemed leaders</p>
        </div>

        <?php
        $leaders = getLeadershipMessages();
        if (!empty($leaders)):
            $count = 0;
            foreach ($leaders as $leader):
                $count++;
                $is_reverse = ($count % 2 == 0);
        ?>

        <!-- Leadership Message: <?php echo htmlspecialchars($leader['name']); ?> -->
        <div style="display: grid; grid-template-columns: <?php echo $is_reverse ? '1fr 350px' : '350px 1fr'; ?>; gap: 50px; align-items: center; margin-bottom: <?php echo ($count == count($leaders)) ? '40px' : '80px'; ?>; background: linear-gradient(135deg, <?php echo $is_reverse ? '#ffffff 0%, #f8f9fa 100%' : '#f8f9fa 0%, #ffffff 100%'; ?>); padding: 50px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">

            <?php if ($is_reverse): ?>
            <!-- Message Content (Left) -->
            <div>
                <div style="position: relative; padding-left: 30px; border-left: 4px solid var(--accent-color);">
                    <i class="fas fa-quote-left" style="font-size: 40px; color: var(--accent-color); opacity: 0.3; position: absolute; top: -10px; left: -20px;"></i>
                    <div style="font-size: 16px; line-height: 1.8; color: var(--text-dark);">
                        <?php echo nl2br(htmlspecialchars($leader['message'])); ?>
                    </div>
                    <div style="margin-top: 25px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                        <?php if (!empty($leader['signature'])): ?>
                            <img src="<?php echo htmlspecialchars($leader['signature']); ?>" alt="Signature" style="height: 50px; margin-bottom: 10px;" onerror="this.style.display='none'">
                        <?php endif; ?>
                        <p style="font-weight: 600; color: var(--primary-color); font-size: 16px;"><?php echo htmlspecialchars($leader['name']); ?></p>
                        <p style="font-size: 14px; color: var(--text-light);"><?php echo htmlspecialchars($leader['designation']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Profile (Right or Left) -->
            <div style="text-align: center;">
                <div style="width: 250px; height: 250px; border-radius: 50%; overflow: hidden; margin: 0 auto 20px; border: 5px solid var(--accent-color); box-shadow: 0 10px 30px rgba(0,0,0,0.2); background: linear-gradient(135deg, var(--primary-color), #0a3a7a);">
                    <?php if (!empty($leader['photo'])): ?>
                        <img src="<?php echo htmlspecialchars($leader['photo']); ?>" alt="<?php echo htmlspecialchars($leader['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; object-position: center top;" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user-tie\' style=\'font-size: 80px; color: white; display: flex; align-items: center; justify-content: center; height: 100%;\'></i>'">
                    <?php else: ?>
                        <i class='fas fa-user-tie' style='font-size: 80px; color: white; display: flex; align-items: center; justify-content: center; height: 100%;'></i>
                    <?php endif; ?>
                </div>
                <h3 style="color: var(--primary-color); font-size: 24px; margin-bottom: 5px;"><?php echo htmlspecialchars($leader['role_title'] ?? 'Leadership Message'); ?></h3>
                <p style="color: var(--text-dark); font-weight: 700; font-size: 20px; margin-bottom: 5px;"><?php echo htmlspecialchars($leader['name']); ?></p>
                <p style="color: var(--text-light); font-size: 14px; line-height: 1.6;"><?php echo htmlspecialchars($leader['designation']); ?></p>
            </div>

            <?php if (!$is_reverse): ?>
            <!-- Message Content (Right) -->
            <div>
                <div style="position: relative; padding-left: 30px; border-left: 4px solid var(--accent-color);">
                    <i class="fas fa-quote-left" style="font-size: 40px; color: var(--accent-color); opacity: 0.3; position: absolute; top: -10px; left: -20px;"></i>
                    <div style="font-size: 16px; line-height: 1.8; color: var(--text-dark);">
                        <?php echo nl2br(htmlspecialchars($leader['message'])); ?>
                    </div>
                    <div style="margin-top: 25px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                        <?php if (!empty($leader['signature'])): ?>
                            <img src="<?php echo htmlspecialchars($leader['signature']); ?>" alt="Signature" style="height: 50px; margin-bottom: 10px;" onerror="this.style.display='none'">
                        <?php endif; ?>
                        <p style="font-weight: 600; color: var(--primary-color); font-size: 16px;"><?php echo htmlspecialchars($leader['name']); ?></p>
                        <p style="font-size: 14px; color: var(--text-light);"><?php echo htmlspecialchars($leader['designation']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <?php
            endforeach;
        else:
        ?>
            <p style="text-align: center; color: var(--text-light); padding: 40px;">No leadership messages available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<div class="case-box">

    <div class="case-box-images">
        <div class="case-box-image">
            <p class="case-box-image-label">BEFORE</p>
            <div class="case-box-image-frame">
                <?php block_field( 'case-before' ); ?>
            </div>
        </div>
        <div class="case-box-image">
            <p class="case-box-image-label case-box-image-label--after">AFTER</p>
            <div class="case-box-image-frame">
                <?php block_field( 'case-after' ); ?>
            </div>
        </div>
    </div>

    <h3 class="case-box-heading">施術内容</h3>
    <div class="case-box-text">
        <?php block_field( 'case-text' ); ?>
    </div>

    <div class="case-box-information">
        <p class="case-box-information-title">治療情報</p>
        <dl class="case-box-information-list">
            <div class="case-box-information-item">
                <dt>治療内容</dt>
                <dd><?php echo esc_html( block_value( 'case-information-content' ) ); ?></dd>
            </div>
            <div class="case-box-information-item">
                <dt>年齢</dt>
                <dd><?php echo esc_html( block_value( 'case-information-age' ) ); ?></dd>
            </div>
            <div class="case-box-information-item">
                <dt>料金</dt>
                <dd><?php echo esc_html( block_value( 'case-information-fee' ) ); ?></dd>
            </div>
            <div class="case-box-information-item">
                <dt>治療期間</dt>
                <dd><?php echo esc_html( block_value( 'case-information-period' ) ); ?></dd>
            </div>
        </dl>
    </div>

    <?php if ( block_value( 'case-information-attention' ) ) : ?>
        <p class="case-box-attention">
            <?php echo esc_html( block_value( 'case-information-attention' ) ); ?>
        </p>
    <?php endif; ?>

    <?php if ( block_value( 'case-btn' ) ) : ?>
        <div class="case-box-btn">
            <a class="case-box-btn-link" href="<?php echo esc_url( block_value( 'case-btn' ) ); ?>">
                他の症例を見る
            </a>
        </div>
    <?php endif; ?>

</div>
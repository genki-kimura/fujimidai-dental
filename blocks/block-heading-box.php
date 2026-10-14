<?php
$tag = block_value( 'heading-box-tag' );
if ( ! $tag ) {
    $tag = 'p';
}
$tag = esc_attr( $tag );
?>
<div class="heading-box">
    <div class="heading-box-top">
        <<?php echo $tag; ?> class="heading-box-title">
            <?php echo esc_html( block_value( 'heading-box-title' ) ); ?>
        </<?php echo $tag; ?>>
    </div>
    <div class="heading-box-bottom">
        <?php block_field( 'heading-box-text' ); ?>
    </div>
</div>
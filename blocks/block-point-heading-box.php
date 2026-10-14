<?php
$tag = block_value( 'point-heading-box-tag' );
if ( ! $tag ) {
    $tag = 'p';
}
$tag = esc_attr( $tag );
?>
<div class="point-heading-box">
    <div class="point-heading-box-tag-top">
        <<?php echo $tag; ?> class="point-heading-box-title">
            <?php echo esc_html( block_value( 'point-heading-box-title' ) ); ?>
        </<?php echo $tag; ?>>
    </div>
    <div class="point-heading-box-bottom">
        <?php block_field( 'point-heading-box-text' ); ?>
    </div>
</div>
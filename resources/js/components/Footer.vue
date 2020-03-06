<template>
    <div class="footer">
        <div class="container">
            <hr>
            <div class="footer__inner">
                <div class="footer__tools">
                    <slot></slot>
                </div>
                <div class="footer__copyright">
                    <p>(C) Copyright By the Pixel</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'Footer'
  }
</script>

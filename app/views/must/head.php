<!DOCTYPE html>
<html>
<head lang="id">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<link rel="icon" href="<?=assets_img('favicon.png')?>">
<link rel="stylesheet" href="<?=assets_css('metro.min.css'); ?>">
<link rel="stylesheet" href="<?=assets_css('style.css')?>">
<link rel="stylesheet" href="<?=assets_css('metro-responsive.min.css')?>">
<link rel="stylesheet" href="<?=assets_css('metro-icons.min.css')?>">
<link rel="stylesheet" href="<?=assets_css('metro-schemes.min.css')?>">
<script src="https://cdn.jsdelivr.net/npm/bluebird@latest/js/browser/bluebird.min.js"></script>
<script>
    Promise.config({
        longStackTraces: false,
        warnings: false
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/axios@latest/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@latest/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/voca@latest/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chance@latest/chance.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@latest/moment.min.js"></script>
<script src="https://unpkg.com/mithril@latest/mithril.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="<?=assets_js('metro.min.js')?>"></script>
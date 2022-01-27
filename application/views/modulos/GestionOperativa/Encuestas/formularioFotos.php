<div class="row justify-content-md-center">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="customSwitch2">
        <label class="custom-control-label" for="customSwitch2">Marcar/Desmarcar todas las casillas</label>
    </div>
</div>
<div class="row justify-content-md-center">
    <?
    foreach ($fotos as $key => $value) {
    ?>
        <div class="col-md-auto" style="margin: 15px;background-color: lightgrey;padding: 5px;border-radius: 5px;">
            <input type="checkbox">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png" style="width:150px;height:150px;border-radius:5px;">
        </div>
        <div class="col-md-auto" style="margin: 15px;background-color: lightgrey;padding: 5px;border-radius: 5px;">
            <input type="checkbox">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png" style="width:150px;height:150px;border-radius:5px;">
        </div>
        <div class="col-md-auto" style="margin: 15px;background-color: lightgrey;padding: 5px;border-radius: 5px;">
            <input type="checkbox">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png" style="width:150px;height:150px;border-radius:5px;">
        </div>
    <?
    }
    ?>
</div>
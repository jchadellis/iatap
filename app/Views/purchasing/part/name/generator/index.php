<!-- <h5>Part Name Generator For Material</h5> -->
<form action="">
<div class="row mb-3">
    <div class="d-flex justify-content-center align-items-center h-100" >
        <div  id="message-alert">

        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-3">
        <label for="part_id">Part ID</label>
        <input type="text" name="part_id" id="part-id" class="form-control">
    </div>
    <div class="col-1">
        <label for="um">UM</label>
        <input type="text" name="unit-measurement" id="unit" class="form-control">
    </div>
    <div class="col-5">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" class="form-control">
    </div>
</div>
<hr>
<div class="row">
    <div class="col-3">
        <input type="hidden" name="user_id" value="<?= auth()->user()->id ?>">
        <div class="row">
            <div class="col-12 mb-3">
                <h6><i class="bi bi-1-circle"></i>&nbsp;Material Form</h6>
                <div class="form-floating">
                    <select name="material-type" id="material-form" class="form-select label">
                        <option value="">Select One</option>
                        <option value="PLT" data-img="<?= base_url('assets/img/material-profiles/sheet.png') ?>" data-target="#sheet">Plate</option>
                        <option value="SHT" data-img="<?= base_url('assets/img/material-profiles/sheet.png') ?>" data-target="#sheet">Sheet</option>
                        <option value="FBR" data-img="<?= base_url('assets/img/material-profiles/flat-bar.png') ?>" data-target="#sheet">Flat Bar</option>
                        <option value="RBR" data-img="<?= base_url('assets/img/material-profiles/round-bar.png') ?>" data-target="#round-bar">Round Bar</option>
                        <option value="ABR" data-img="<?= base_url('assets/img/material-profiles/angle-bar.png') ?>" data-target="#angle-bar">Angle Bar</option>
                        <option value="STB" data-img="<?= base_url('assets/img/material-profiles/square-tubing.png') ?>" data-target="#tubing">Square Tube</option>
                        <option value="RTB" data-img="<?= base_url('assets/img/material-profiles/rectangle-tubing.png') ?>" data-target="#tubing">Rectangle Tube</option>
                        <option value="TUB" data-img="<?= base_url('assets/img/material-profiles/round-tubing.png') ?>" data-target="#round-tubing">Round Tube</option>
                        <option value="CHN" data-img="<?= base_url('assets/img/material-profiles/channel.png') ?>" data-target="#channel">Channel</option>
                        <option value="PIP" data-img="<?= base_url('assets/img/material-profiles/round-bar.png') ?>" data-target="#round-bar">Pipe</option>
                        <option value="BEM" data-img="<?= base_url('assets/img/material-profiles/i-beam.png') ?>" data-target="#beam">Beam</option>
                        <option value="EXM" data-img="<?= base_url('assets/img/material-profiles/expanded-metal.png') ?>" data-target="#sheet">Expanded Metal</option>
                        <option value="FEM" data-img="<?= base_url('assets/img/material-profiles/expanded-metal.png') ?>" data-target="#sheet">Flatten Expanded Metal</option>
                        <option value="GRT" data-img="<?= base_url('assets/img/material-profiles/expanded-metal.png') ?>" data-target="#sheet">Grating</option>
                        <option value="TRP" data-img="<?= base_url('assets/img/material-profiles/expanded-metal.png') ?>" data-target="#sheet">Tread Plate</option>
                    </select>
                    <label for="type">Material Type</label>
                </div>
            </div>
            <div class="col-12">
                <img class="figure-img img-fluid rounded" id="profile" src="<?= base_url('assets/img/material-profiles/sheet.png') ?>" alt="">
            </div>
        </div>
    </div>
    <div class="col p-3" style="background-color: #D9F8FF">
        <div class="row mb-3">
            <div class="col-4">
                <h6><i class="bi bi-3-circle"></i>&nbsp;Material Type</h6>
                <div class="form-floating">
                    <select name="material_type" id="material-type" class="form-select label">
                        <option value="ALU">Aluminum</option>
                        <option value="ALLY">Alloy</option>
                        <option value="STL">Steel</option>
                        <option value="SST">Stainless Steel</option>
                        <option value="PLA">Plastic</option>
                        <option value="FOM">Foam</option>
                        <option value="WOD">Wood</option>
                        <option value="OTH">Other</option>
                    </select>
                    <label for="unit_measurement">Material Type</label>
                </div>
            </div>
            <div class="col-4">
                <h6><i class="bi bi-2-circle"></i>&nbsp;Unit of Measurement</h6>
                <div class="form-floating">
                    <select name="unit-measurement" id="unit-measurement" class="form-select label">
                        <option value="FT" selected>Feet</option>
                        <option value="EA">Each</option>
                        <option value="IN">Inches</option>
                        <option value="M">Meter</option>
                    </select>
                    <label for="unit_measurement">Unit of Measurement</label>
                </div>
            </div>

        </div>
        <div class="row">
            <h6><i class="bi bi-4-circle"></i>&nbsp;Dimenisions</h6>
        </div>
        <div id="dim-parent">
            <!-- Sheet Goods Container --> 
            <div class="row mb-3 collapse g-2" id="sheet"  data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->

                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->

                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- Round Bar / Pipe Container --> 
            <div class="row mb-3 collapse g-2" id="round-bar" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Diameter</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- Angle Bar Contain --> 
            <div class="row mb-3 collapse g-2" id="angle-bar" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Leg 1</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Leg 2</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-4" id="field-4" placeholder="" class="form-control dim">
                        <label for="field-4">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-4-unit" id="field-4-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-4-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- Square / Rectangle Tubing Container --> 
            <div class="row mb-3 collapse g-2" id="tubing" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Height</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-4" id="field-4" placeholder="" class="form-control dim">
                        <label for="field-4">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-4-unit" id="field-4-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-4-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- Round Tubing Container --> 
            <div class="row mb-3 collapse g-2" id="round-tubing" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim" >
                        <label for="field-2">Diameter</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- Pipe and Round Bar Container --> 
            <div class="row mb-3 collapse g-2" id="round-bar" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Height</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-4" id="field-4" placeholder="" class="form-control dim">
                        <label for="field-4">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-4-unit" id="field-4-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-4-unit">Unit</label>
                    </div>
                </div> -->
            </div>
            <!-- Channel Stock Container --> 
            <div class="row mb-3 collapse g-2" id="channel" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Inside Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Outside Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-4" id="field-4" placeholder="" class="form-control dim">
                        <label for="field-4">Height</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-4-unit" id="field-4-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-4-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-5" id="field-5" placeholder="" class="form-control dim">
                        <label for="field-5">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-5-unit" id="field-5-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;"> 
                        <label for="field-5-unit">Unit</label>
                    </div>
                </div> -->
            </div>

            <!-- I Beam Container --> 
            <div class="row mb-3 collapse g-2" id="beam" data-bs-parent="#dim-parent">
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-1" id="field-1" placeholder="" class="form-control dim">
                        <label for="field-1">Flange Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-1-unit" id="field-1-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-1-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-2" id="field-2" placeholder="" class="form-control dim">
                        <label for="field-2">Web Thickness</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-2-unit" id="field-2-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-2-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-3" id="field-3" placeholder="" class="form-control dim">
                        <label for="field-3">Width</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-3-unit" id="field-3-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-3-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-4" id="field-4" placeholder="" class="form-control dim">
                        <label for="field-4">Height</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-4-unit" id="field-4-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-4-unit">Unit</label>
                    </div>
                </div> -->
                <div class="col-2">
                    <div class="form-floating">
                        <input type="text" name="field-5" id="field-5" placeholder="" class="form-control dim">
                        <label for="field-5">Length</label>
                    </div>
                </div>
                <!-- <div class="col-1">
                    <div class="form-floating">
                        <input type="text" name="field-5-unit" id="field-5-unit" placeholder="" class="form-control" style="background-color: #fbfbd1ff;">
                        <label for="field-5-unit">Unit</label>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h6><i class="bi bi-5-circle"></i>&nbsp;Material Properties</h6>
            </div>
            <div class="col-7">
                <h6><i class="bi bi-6-circle"></i>&nbsp;Standards</h6>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-3">
                  <div class="form-floating">
                    <select name="material-property" id="material-property" class="form-select">
                        <option value=""></option>
                        <option value="temper">Temper</option>
                        <option value="condition">Condition</option>
                        <option value="durometer">Durometer</option>
                    </select>
                    <label for="material-property">Properties</label>
                </div>
            </div>
            <div class="col-2">
                <div class="form-floating">
                    <input type="text" name="material-property-value" id="material-property-value" class="form-control" placeholder="">
                    <label for="">Value</label>
                </div>
            </div>
            <div class="col-4">
                <div class="form-floating">
                    <select name="standard" id="standard" class="form-select">
                        <option value=""></option>
                        <option value="asm">ASM - Aerospace Material Specification</option>
                        <option value="astm">ASTM - American Society for Testing and Material</option>
                        <option value="spec">Specification</option>
                    </select>
                    <label for="standard">Standard</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-floating">
                    <input type="text" name="standard-number" id="standard-number" class="form-control" placeholder="">
                    <label for="">Number</label>
                </div>
            </div>

        </div>
    </div>
</div>
</form>
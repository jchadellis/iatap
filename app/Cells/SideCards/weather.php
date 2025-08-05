<div class="card border-0 h-100" style="border-color: var(--bs-purple);">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-sm font-weight-bold text-gray text-uppercase mb-2 pb-1"><i class="bi bi-cloud-sun"></i>
                <span id="card-title"><?= $weather['name'] ?></span>
                </div>
                <div style="color: var(--bs-gray-600)">
                    <p class="p-0 m-0"><?= $weather['shortForecast'] ?></p>
                    <p class="p-0 m-0 fs-6"><?= 'High Near: ' . $weather['temperature'].$weather['temperatureUnit']. ' Wind : ' . $weather['windDirection'] . ' ' . $weather['windSpeed'] ?></p>
                </div>
            </div>
            <div class="col-auto">
                
            </div>
        </div>
    </div>
</div>
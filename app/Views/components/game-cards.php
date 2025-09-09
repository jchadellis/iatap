    <style>
        .home-tile:hover{
            background-color: #d7d7d7ff !important;
        }
        .away-tile:hover{
            background-color: #434242ff !important;
        }
    </style>

<div class="row">
    <?php if( isset($games) ) : ?>
   <?php foreach($games as $game ) : ?>
    <?php 
        $today = new \DateTime(); 
        $startDate = new \DateTime($game['startDate']); 
    ?>

    <div class="col-3">
        <div class="card mb-3 rounded-0">
            <div class="row g-0 d-flex align-items-center">
                <!-- Team 1 Side -->
                <div class="col-md-6">
                    <?php if(true) : ?>
                    <a href="<?= base_url("cfb-football/team/{$game['awayId']}/{$week}") ?>">
                        <div class="card-body text-center away-tile" style="background-color:<?= $game['awayColor'] ?>">
                        <img
                            src="<?= $game['awayLogo']?>"
                            class="img-fluid rounded-end"
                        />
                        </div>
                    </a>
                    <?php else: ?>
                        <div class="card-body text-center away-tile" style="background-color:<?= $game['awayColor'] ?>">
                        <img
                            src="<?= $game['awayLogo']?>"
                            class="img-fluid rounded-end"
                        />
                        </div>
                    <?php endif; ?>
                </div>


                <!-- Team 2 Side -->
                <div class="col-md-6">
                    <?php if(true) : ?>
                    <a href="<?= base_url("cfb-football/team/{$game['homeId']}/{$week}") ?>">
                        <div class="card-body text-center home-tile" style="background-color:<?= $game['homeColor'] ?>">
                        <img
                            src="<?= $game['homeLogo']?>"
                            class="img-fluid rounded-end"
                        />
                        </div>
                    </a>
                    <?php else: ?>
                        <div class="card-body text-center home-tile" style="background-color:<?= $game['homeColor'] ?>">
                        <img
                            src="<?= $game['homeLogo']?>"
                            class="img-fluid rounded-end"
                        />
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row g-0" style="background-color: #333333; color: #FFFFFF">
                <div class="col-5 text-center">
                    <span class="align-middle text-truncate" style="font-size: 9pt"><?= $game['awayRank'] ? '#'.$game['awayRank'] : '' ?> <?= $game['awayName']?> &nbsp; ( <?= $game['awayTeamWins'] ?> - <?= $game['awayTeamLosses'] ?> )</span>
                </div>
                <div class="col-md-2">
                    <h6 class="text-center">
                        <span class="align-middle">vs</span>
                    </h6>
                </div>
                <div class="col-5 text-center">
                    <span class="align-middle text-truncate" style="font-size: 9pt"><?= $game['homeRank'] ? '#'.$game['homeRank'] : '' ?> <?= $game['homeName']?> &nbsp; ( <?= $game['homeTeamWins'] ?> - <?= $game['homeTeamLosses'] ?> )</span>
                </div>
            </div>
            <div class="row g-0 d-flex align-items-center border-top">
                <div class="col-md-5">
                    <h2 class="text-center text-muted"><?= $game['awayPoints'] ?? '0' ?></h2>
                </div>
                <div class="col-md-2">
                    <h1 class="h1 text-center">-</h1>
                </div>
                <div class="col-md-5">
                    <h2 class="text-center text-muted"><?= $game['homePoints'] ?? '0' ?></h2>
                </div>
            </div>      
            <div class="row g-0 border-top" style="background-color: #333333; color: #FFFFFF">
                <div class="col">
                    <?php if($today <= $startDate): ?>
                    <h6 class="h6 text-center text-white"><span class="align-middle"><?= (new DateTime($game["startDate"]))->setTimezone(new DateTimeZone('America/Chicago'))->format('g:i a') ?>&nbsp;CST</span></h6>
                    <?php else: ?>
                        <h6 class="h6 text-center text-white"><span class="align-middle">FINAL</span></h6>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>


    <div class="row mb-4">
        <div class="col-12">
            <div class="card rounded-0 border-0">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div class="flex-column p-3"><img src="<?= $team['logos'][0] ?>" alt="" style="width: 150p; height:150px" class="rounded-0"></div>
                        <div class="d-flex flex-column border-start p-3">
                            <h1 class="h3 mb-0"><?= $team['ranks']['ap'] ? '#'. $team['ranks']['ap'] :  '' ?> <?= $team['school']?> - <?= $team['mascot'] ?></h1> 
                            <p class="mb-0"><span class="fw-bold">Record:</span> <?= $team['record']['total']['wins'] ?> - <?= $team['record']['total']['losses'] ?><span class="fw-bold"> Conference Record:</span> <?= $team['record']['conferenceGames']['wins'] ?> - <?= $team['record']['conferenceGames']['losses'] ?> </p>
                            <p class="mb-0"><?= $team['mascot'] ?> (<?= $team['abbreviation'] ?>)</p>
                            <p class="mb-0"><span class="fw-bold">Conference:</span> <?= $team['conference'] ?> | <span class="fw-bold">Class:</span> <?= strtoupper($team['classification']) ?></p>
                            <p class="mb-0"><span class="fw-bold"><?= $team['location']['name'] ?></span> <?= $team['location']['city'] ?>, <?= $team['location']['state'] ?> <?= $team['location']['zip'] ?></p>
                            <p class="mb-0"><span class="fw-bold">Twitter:</span> <a href="https://twitter.com/<?= ltrim($team['twitter'], '@') ?>" target="_blank"><?= $team['twitter'] ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Stats Table -->
    <h5 class="p-3" style="background-color:<?= $team['color'] ?>; color: <?= $team['alternateColor'] ?>">Team Stats <?= date('Y') ?></h5>
    <table class="table align-middle">
        <thead class="" >
            <tr>
                <th class="text-center"></th>
                <th class="text-center">TEAM</th>
                <th class="text-center">OPPPONENTS</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($team['stats'] as $stat): ?>
            <tr>
                <td class="fw-bold"><?= $stat['statName'] ?? '' ?></td>
                <td class="text-center"><?= $stat['teamStat'] ?? '' ?></td>
                <td class="text-center"><?= $stat['opponentStat'] ?? 'N/A' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

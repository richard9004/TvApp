<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/WeekdayFormatter.php';
try {
    $title = isset($_GET['title']) ? trim($_GET['title']) : null;
    $timedate = isset($_GET['timedate']) ? trim($_GET['timedate']) : null;
    $requestDTO = new Request($title, $timedate);
    $weekdayFormatter = new WeekdayFormatter();

    $response = $seriesController->getNextAiringSeries($requestDTO);
   
} catch (Exception $e) {
    error_log($e->getMessage()); // Log the specific error
    echo "<p>Error, Please try again</p>".$e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TV Series Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Search</h2>
        <form method="GET" class="row g-2">
            <div class="col-auto">
                <label for="title" class="visually-hidden">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                       value="<?php echo htmlspecialchars($_GET['title'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <label for="timedate" class="visually-hidden">Date & Time</label>
                <input type="datetime-local" class="form-control" id="timedate" name="timedate" placeholder="Date & Time"
                       value="<?php echo htmlspecialchars($_GET['timedate'] ?? '') ?>">
            </div>
            <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="row mt-2">
            <?php 
            if (isset($response['status']) && $response['status'] === 'error'): ?>
                <div class="alert alert-danger mt-3">
                    <?php foreach($response['errors'] as $error): ?>
                    <?php echo htmlspecialchars($error); ?>
                    <?php endforeach; ?>    
                   
                </div>
            <?php elseif (isset($response['status']) && $response['status'] === 'success' && $response['data'] !== null): 
                $series = $response['data'];
                $readableTime = DateTime::createFromFormat('H:i:s', $series->airingTime)->format('h:i A'); 
                $weekdayName = $weekdayFormatter->getWeekdayName($series->weekDay);
            ?>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Next Airing
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($series->title); ?></h5>
                            <p class="card-text">
                                <strong>Channel:</strong> <?php echo htmlspecialchars($series->channel); ?><br>
                                <strong>Airing Day:</strong> <?php echo $weekdayName; ?><br>
                                <strong>Airing Time:</strong> <?php echo $readableTime; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-12">
                    <p>No series found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
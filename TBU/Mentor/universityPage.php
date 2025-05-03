<?php
$name = $_GET['name'] ?? 'Unknown University';
$jsonPath = 'assets/data/universities.json';

$universityData = [];
if (file_exists($jsonPath)) {
    $jsonContent = file_get_contents($jsonPath);
    $universityData = json_decode($jsonContent, true);
}

$data = $universityData[$name] ?? null;
$imagePath = 'assets/img/universities/' . ($data['image'] ?? 'default_university.jpg');
if (!file_exists($imagePath)) {
    $imagePath = 'assets/img/default_university.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($name) ?> - University Info</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
        }

        .card {
        max-width: 1100px; /* Increased from 900px */
        width: 100%;
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        overflow: hidden;
}


        .university-img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .card-body {
            padding: 2rem;
            text-align: justify;
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-item i {
            width: 25px;
            color: #495057;
        }

        .btn-custom {
            background-color: #6c5ce7;
            color: white;
            border-radius: 6px;
        }

        .btn-custom:hover {
            background-color: #5a4bdc;
            color: white;
        }

        @media (max-width: 768px) {
            .university-img {
                height: 250px;
                border-radius: 12px 12px 0 0;
            }

            .row.g-0 {
                flex-direction: column;
            }
        }

        .btntour{
            background-color: #823341;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            display: inline-block;
            text-align: center;
        }
        .btntour:hover{
            background-color: #b54c5f;
            color: white;
        }
    </style>
</head>
<body>

<?php if ($data): ?>
    <div class="card">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($name) ?>" class="university-img">
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <h2 class="card-title mb-4"><?= htmlspecialchars($name) ?></h2>

                    <div class="info-item">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Description:</strong>
                        <p><?= htmlspecialchars($data['description']) ?></p>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <?= htmlspecialchars($data['location']) ?>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-globe me-2"></i>
                        <a href="<?= htmlspecialchars($data['website']) ?>" target="_blank"><?= htmlspecialchars($data['website']) ?></a>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-robot"></i>
                        <a href="<?= htmlspecialchars($data['chatBot']) ?>" class="btn btn-sm btn-outline-primary ms-2">Talk to Bot</a>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="tour.php" class="btntour btn">
                            <i class="fa-solid fa-globe me-2"></i> Tour
                        </a>
                        <a href="result.php" class="btn btn-secondary">← Back to Results</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center mt-5">
        <h4>University Not Found</h4>
        <p>Sorry, we couldn't find info on that university.</p>
        <a href="result.php" class="btn btn-secondary mt-3">← Back to Results</a>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// universityPage.php
$name = $_GET['name'] ?? 'Unknown University';

$universityData = [
    'MIT' => [
        'description' => 'Massachusetts Institute of Technology is a world leader in technology and innovation.',
        'location' => 'Cambridge, Massachusetts, USA',
        'website' => 'https://www.mit.edu',
        'image' => 'mit.jpg'
    ],
    'Oxford' => [
        'description' => 'The University of Oxford is one of the oldest and most prestigious universities in the world.',
        'location' => 'Oxford, England',
        'website' => 'https://www.ox.ac.uk',
        'image' => 'oxford.jpg'
    ],
    'Tirana University' => [
        'description' => 'A leading public university in Albania known for its wide range of programs.',
        'location' => 'Tirana, Albania',
        'website' => 'https://www.unitir.edu.al',
        'image' => 'tirana_university.jpg'
    ],
    'Harvard' => [
        'description' => 'Harvard University is a private Ivy League research university in Cambridge, Massachusetts.',
        'location' => 'Cambridge, Massachusetts, USA',
        'website' => 'https://www.harvard.edu',
        'image' => 'harvard.jpg'
    ],
    'LSE' => [
        'description' => 'The London School of Economics is a public research university in London, England.',
        'location' => 'London, UK',
        'website' => 'https://www.lse.ac.uk',
        'image' => 'lse.jpg'
    ],
    // Add more unis as needed
];

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
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .university-card {
            max-width: 800px;
            margin: 50px auto;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #fff;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }
        .university-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .university-body {
            padding: 30px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($data): ?>
        <div class="university-card">
            <img src="<?= htmlspecialchars($imagePath) ?>" class="university-img" alt="<?= htmlspecialchars($name) ?>">
            <div class="university-body">
                <h2><?= htmlspecialchars($name) ?></h2>
                <p><strong>Description:</strong> <?= htmlspecialchars($data['description']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($data['location']) ?></p>
                <p><strong>Website:</strong> <a href="<?= htmlspecialchars($data['website']) ?>" target="_blank"><?= htmlspecialchars($data['website']) ?></a></p>
                <a href="result.php" class="btn btn-secondary btn-back">← Back to Results</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-5 text-center">
            <h4>University Not Found</h4>
            <p>Sorry, we couldn't find info on that university.</p>
            <a href="result.php" class="btn btn-secondary mt-3">← Back to Results</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

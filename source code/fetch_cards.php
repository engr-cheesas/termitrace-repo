<?php
$cards = [
    ["title" => "Card 1", "content" => "This is card 1."],
    ["title" => "Card 2", "content" => "This is card 2."],
    ["title" => "Card 3", "content" => "This is card 3."],
    ["title" => "Card 4", "content" => "This is card 4."],
    ["title" => "Card 5", "content" => "This is card 5."],
    ["title" => "Card 6", "content" => "This is card 6."]
];

foreach ($cards as $card) {
    echo '<div class="col-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">'.htmlspecialchars($card['title']).'</h5>
                    <p class="card-text">'.htmlspecialchars($card['content']).'</p>
                </div>
            </div>
          </div>';
}
?>

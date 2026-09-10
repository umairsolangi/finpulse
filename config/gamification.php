<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gamification Activity Points Configuration
    |--------------------------------------------------------------------------
    |
    | Defines the point values awarded for community and learning activities.
    | Points contribute both to cumulative user activity_score and to weekly
    | leaderboard rankings.
    |
    */
    'points' => [
        'post_created' => 5,
        'comment_created' => 2,
        'reaction_given' => 1,
        'content_completed' => 3, // Stub for future course/content completion tracking
    ],
];

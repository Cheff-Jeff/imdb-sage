<?php

declare(strict_types=1);

namespace App\View\Composers;

use Illuminate\Support\Collection;
use Roots\Acorn\View\Composer;

class Cast extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single-cast',
        'archive-cast',
    ];

    /**
     * Movies this person worked on, with their role(s), from the "movies_casting" repeater.
     *
     * @return Collection<int, array{movie: \WP_Post, roles: string[]}>
     */
    public function filmography(): Collection
    {
        $rows = get_field('movies_casting', get_queried_object_id()) ?: [];

        return collect($rows)
            ->map(function ($row) {
                $movie = $row['movie_post'] ?? null;

                return [
                    'movie' => is_object($movie) ? $movie : get_post((int) $movie),
                    'role' => trim((string) ($row['role'] ?? '')),
                ];
            })
            ->filter(fn ($row) => $row['movie'] instanceof \WP_Post && $row['movie']->post_status === 'publish')
            // One entry per movie, even when someone has several roles in it
            ->groupBy(fn ($row) => $row['movie']->ID)
            ->map(fn ($rows) => [
                'movie' => $rows->first()['movie'],
                'roles' => $rows->pluck('role')->filter()->unique()->values()->all(),
            ])
            ->values();
    }

    /**
     * Tags used on cast members (e.g. Acteur, Director), for the filter on the archive.
     *
     * @return \WP_Term[]
     */
    public function professions(): array
    {
        $castIds = get_posts([
            'post_type' => 'cast',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);

        if (! $castIds) {
            return [];
        }

        $terms = get_terms([
            'taxonomy' => 'post_tag',
            'object_ids' => $castIds,
            'orderby' => 'name',
        ]);

        return is_wp_error($terms) ? [] : $terms;
    }

    /**
     * Slug of the profession filter that is active on the archive (?tag=...).
     */
    public function activeProfession(): string
    {
        return (string) get_query_var('tag');
    }
}

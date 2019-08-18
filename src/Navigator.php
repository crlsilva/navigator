<?php

namespace DesignCafe\Navigator;

/**
 * Class Navigator
 * @package DesignCafe\Navigator
 */
class Navigator
{
    /** @var int */
    private $page;

    /** @var int */
    private $pages;

    /** @var int */
    private $rows;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /** @var int */
    private $range;

    /** @var string */
    private $link;

    /** @var string */
    private $title;

    /** @var string */
    private $class;

    /** @var string */
    private $hash;

    /** @var array */
    private $first;

    /** @var array */
    private $last;

    /** @var int */
    private $links;

    /** @var int */
    private $min;

    /** @var int */
    private $max;

    /** @var int */
    private $qt_nav;

    /** @var bool */
    private $total;

    /**
     * Navigator constructor.
     * @param string|null $link
     * @param string|null $title
     * @param array|null $first
     * @param array|null $last
     */
    public function __construct(string $link = null, string $title = null, array $first = null, array $last = null)
    {
        $this->link = ($link ?? "?page=");
        $this->title = ($title ?? "Página");
        $this->first = ($first ?? ["Primeira página", "<<"]);
        $this->last = ($last ?? ["Última página", ">>"]);
    }

    /**
     * @param int $rows
     * @param int $limit
     * @param int|null $page
     * @param int $links
     * @param bool $total
     * @param string|null $hash
     */
    public function pager(int $rows, int $limit = 10, int $page = null, int $links = 7, string $hash = null
    ): void
    {
        $this->rows = $this->toPositive($rows);
        $this->limit = $this->toPositive($limit);
        $this->pages = (int)ceil($this->rows / $this->limit);
        $this->links = $this->pages < $links ? $this->pages : $links;
        $this->hash = (!empty($hash) ? "#{$hash}" : null);
        $this->page = ($page <= $this->pages ? $this->toPositive($page) : $this->pages);

        $this->range();

        $this->qtNav();

        $this->checkOffset();
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pages(): int
    {
        return $this->pages;
    }

    /**
     * @param string $cssClass
     * @return null|string
     */
    public function render(string $cssClass = "navigator"): ?string
    {
        $this->class = $cssClass;

        if ($this->rows > $this->limit):
            $navigator = "<nav class=\"{$this->class}\">";
            $navigator .= $this->firstPageLink();
            $navigator .= $this->beforePages();
            $navigator .= "<span class=\"{$this->class}_item {$this->class}_active\">{$this->page}</span>";
            $navigator .= $this->afterPages();
            $navigator .= $this->lastPageLink();
            $navigator .= "</nav>";
            $navigator .= ($this->total && $this->links ? "<span>Página {$this->page} de {$this->pages}</span>" : '');
            return $navigator;
        endif;

        return null;
    }

    /**
     * @return string
     */
    private function firstPageLink(): string
    {
        return ($this->page == 1) ?
            "<a class='{$this->class}_item' title='{$this->first[0]}' href='#' onclick='return false;'>{$this->first[1]}</a>" :
            "<a class='{$this->class}_item' title='{$this->first[0]}' href='{$this->link}1{$this->hash}'>{$this->first[1]}</a>";
    }

    /**
     * @return string
     */
    private function lastPageLink(): string
    {
        return ($this->page == $this->pages) ?
            "<a class='{$this->class}_item' title='{$this->last[0]}' href='#' onclick='return false;'>{$this->last[1]}</a>" :
            "<a class='{$this->class}_item' title='{$this->last[0]}' href='{$this->link}{$this->pages}{$this->hash}'>{$this->last[1]}</a>";
    }

    /**
     * @return null|string
     */
    private function beforePages(): ?string
    {
        $before = null;

        if (($this->min > 1) && ($this->qt_nav < $this->links)) {
            $this->min = $this->min - ($this->links - $this->qt_nav);
        }

        for ($iPag = $this->min; $iPag <= $this->page - 1; $iPag++):
            if ($iPag >= 1):
                $before .= "<a class='{$this->class}_item' title=\"{$this->title} {$iPag}\" href=\"{$this->link}{$iPag}{$this->hash}\">{$iPag}</a>";
            endif;
        endfor;

        return $before;
    }

    /**
     * @return string|null
     */
    private function afterPages(): ?string
    {
        $after = null;

        if (($this->max < $this->pages) && ($this->qt_nav < $this->links)) {
            $this->max = $this->max + ($this->links - $this->qt_nav);
        }

        for ($dPag = $this->page + 1; $dPag <= $this->max; $dPag++):
            if ($dPag <= $this->pages):
                $after .= "<a class='{$this->class}_item' title=\"{$this->title} {$dPag}\" href=\"{$this->link}{$dPag}{$this->hash}\">{$dPag}</a>";
            endif;
        endfor;

        return $after;
    }

    /**
     * Calculate the range of pages
     */
    private function range(): void
    {
        if ($this->isEven($this->links)) {
            $this->links = $this->toPositive($this->links + 1);
            $this->range = $this->toPositive($this->links / 2);
        } else {
            $this->range = ($this->toPositive(($this->links - 1) / 2));
        }
    }

    /**
     * Define the Navigation Links quantity
     */
    private function qtNav(): void
    {
        $this->min = $this->toPositive($this->page - $this->range);
        $this->max = ($this->page + $this->range) > $this->pages ? $this->pages : $this->page + $this->range;
        $this->qt_nav = $this->max - $this->min + 1;
    }

    /**
     * Prevent the offset overbook
     */
    private function checkOffset(): void
    {
        $this->offset = (($this->page * $this->limit) - $this->limit >= 0 ? ($this->page * $this->limit) - $this->limit : 0);

        if ($this->rows && $this->offset >= $this->rows) {
            header("Location: {$this->link}" . ceil($this->rows / $this->limit));
            return;
        }
    }

    /**
     * @param $number
     * @return int
     */
    private function toPositive($number): int
    {
        return ($number >= 1 ? $number : 1);
    }

    /**
     * @param $number
     * @return bool
     */
    private function isEven($number): bool
    {
        return ($number % 2) ? false : true;
    }
}
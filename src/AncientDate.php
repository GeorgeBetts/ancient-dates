<?php

namespace Gbetts\AncientDates;

class AncientDate
{

    public function __construct(protected string $date)
    {
        if (!$this->validate()) {
            throw new \InvalidArgumentException(
                'Invalid date format. Expected format: -yyyy-mm-ddThh:mm:ssZ (e.g. "-155000000-01-01T00:00:00Z")'
            );
        }
    }

    /**
     * Formats the date as a BCE string e.g. '3000 years BCE'
     */
    public function toBceString(): string
    {
        $yearsBce = explode('-', $this->date)[1];
        if (strlen($yearsBce) > 6) {
            $yearsBce = (intval($yearsBce) / 1000000) . ' million';
        }
        return $yearsBce . " years BCE";
    }

    /**
     * Get the number of years since the date
     */
    public function yearsAgo(): int
    {
        $yearsBce = (int) explode('-', $this->date)[1];
        $currentYear = (int) date('Y');

        return $yearsBce + $currentYear;
    }


    /**
     * Get the geological period name based on the date e.g. Jurassic
     */
    public function period(): string
    {
        $yearsBce = intval(explode('-', $this->date)[1]) / 1000000;
        return match (true) {
            $yearsBce < 0.0042 => 'Modern',
            $yearsBce >= 0.0042 && $yearsBce < 3.6 => 'Quaternary',
            $yearsBce >= 3.6 && $yearsBce < 28.1 => 'Neogene',
            $yearsBce >= 28.1 && $yearsBce < 72.1 => 'Paleogene',
            $yearsBce >= 72.1 && $yearsBce < 152.1 => 'Cretaceous',
            $yearsBce >= 152.1 && $yearsBce < 208.5 => 'Jurassic',
            $yearsBce >= 208.5 && $yearsBce < 254.14 => 'Triassic',
            $yearsBce >= 254.14 && $yearsBce < 303.7 => 'Permian',
            $yearsBce >= 303.7 && $yearsBce < 372.2 => 'Carboniferous',
            $yearsBce >= 372.2 && $yearsBce < 423 => 'Devonian',
            $yearsBce >= 423 && $yearsBce < 445.2 => 'Silurian',
            $yearsBce >= 445.2 && $yearsBce < 489.5 => 'Ordovician',
            $yearsBce >= 489.5 && $yearsBce < 635 => 'Cambrian',
            $yearsBce >= 635 => 'Precambrian',
            default => 'Unknown',
        };
    }

    protected function validate(): bool
    {
        return preg_match_all('/^-[0-9]+-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]+Z$/', $this->date) > 0;
    }
}
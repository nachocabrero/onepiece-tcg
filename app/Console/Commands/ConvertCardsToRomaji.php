<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Card;
use Illuminate\Support\Facades\DB;

class ConvertCardsToRomaji extends Command
{
    protected $signature = 'cards:romaji';
    protected $description = 'Convert Japanese card names/characters to romaji';

    public function handle()
    {
        $this->includeKana2Roma();

        $cards = Card::whereNull('name_es')->orWhereNull('character_es')->get();
        $total = $cards->count();
        $this->info("Found {$total} cards to process.");

        $updated = 0;
        $errors = 0;

        $this->newLine();
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($cards as $card) {
            try {
                $updatedFields = [];

                if (empty($card->name_es) && $this->needsConversion($card->name)) {
                    $card->name_es = $this->cleanRomaji($this->convert($card->name));
                    $updatedFields[] = 'name_es';
                }

                if (empty($card->character_es) && $this->needsConversion($card->character)) {
                    $card->character_es = $this->cleanRomaji($this->convert($card->character));
                    $updatedFields[] = 'character_es';
                }

                if (!empty($updatedFields)) {
                    $card->save();
                    $updated++;
                }
            } catch (\Exception $e) {
                $errors++;
                $this->error("Error on card #{$card->id} ({$card->card_number}): {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Done! Updated: {$updated}, Errors: {$errors}");
    }

    protected function includeKana2Roma(): void
    {
        $file = __DIR__ . '/../../vendor/hikarine3/kana2roma/src/Kana2Roma.php';
        if (file_exists($file)) {
            include $file;
        }
    }

    protected function convert(string $text): string
    {
        if (!class_exists('Hikarine3\Kana2Roma')) {
            return $text;
        }
        $k = new \Hikarine3\Kana2Roma();
        return $k->convert($text);
    }

    protected function cleanRomaji(string $text): string
    {
        // Remove leading/trailing whitespace
        $text = trim($text);
        // Replace middle dots with spaces for readability
        $text = str_replace('・', ' ', $text);
        // Collapse multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);
        return $text;
    }

    protected function needsConversion(string $text): bool
    {
        // Check if text contains Japanese characters (kana or kanji)
        return preg_match('/[\x{3040}-\x{30FF}\x{4E00}-\x{9FFF}\x{3400}-\x{4DBF}]/u', $text) === 1;
    }
}
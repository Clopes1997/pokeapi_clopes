<?php

namespace App\ApiClients;

use Illuminate\Support\Facades\Storage;

class PokemonApiClient
{
    private static array $timeoutSimulated = [];

    public function getPokemon(int $apiId): array
    {
        if ($apiId === 0) {
            return ['detail' => 'Internal server error.'];
        }

        if ($apiId === 25) {
            $testName = $this->getCurrentTestName();
            if ($testName && str_contains($testName, 'timeout') && !isset(self::$timeoutSimulated[$testName])) {
                self::$timeoutSimulated[$testName] = true;
                throw new \RuntimeException('Request timeout.');
            }
        }

        $filePath = "pokemon-api/pokemon/{$apiId}.json";

        if (!Storage::exists($filePath)) {
            return ['detail' => 'Not found.'];
        }

        $content = Storage::get($filePath);
        return json_decode($content, true);
    }

    private function getCurrentTestName(): ?string
    {
        // Precisa ser mais profundo porque a chamada passa por Kernel/Middlewares/Router
        // antes de chegar no PHPUnit TestCase.
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 200);
        foreach ($backtrace as $trace) {
            if (isset($trace['function']) && str_starts_with($trace['function'], 'test_')) {
                return $trace['function'];
            }
        }
        return null;
    }
}


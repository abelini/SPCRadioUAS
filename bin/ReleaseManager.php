<?php

declare(strict_types=1);

final class ReleaseManager
{
    private const COMPOSER_FILE = __DIR__ . '/../composer.json';
    private const VERSION_PATTERN = '/^\d+\.\d+\.\d+$/';

    /**
     * Ejecuta el flujo completo: valida, actualiza composer.json,
     * hace commit, crea el tag y lo sube a GitHub.
     */
    public function release(string $bumpType): void
    {
        $this->assertCleanWorkingTree();

        $currentVersion = $this->readCurrentVersion();
        $newVersion = $this->calculateNextVersion($currentVersion, $bumpType);

        $this->writeVersion($newVersion);
        $this->run(sprintf('git add composer.json'));
        $this->run(sprintf('git commit -m %s', escapeshellarg("Release v{$newVersion}")));
        $this->run(sprintf('git tag -a v%s -m %s', $newVersion, escapeshellarg("Versión {$newVersion}")));
        $this->run('git push origin HEAD');
        $this->run(sprintf('git push origin v%s', $newVersion));

        echo "Versión {$currentVersion} → {$newVersion} publicada.\n";
    }

    /**
     * Lee la versión actual desde composer.json.
     */
    private function readCurrentVersion(): string
    {
        $data = $this->readComposerData();
        $version = $data['version'] ?? '0.0.0';

        if (preg_match(self::VERSION_PATTERN, $version) !== 1) {
            throw new RuntimeException("Versión inválida en composer.json: {$version}");
        }

        return $version;
    }

    /**
     * Calcula la siguiente versión según el tipo de incremento.
     */
    private function calculateNextVersion(string $version, string $bumpType): string
    {
        [$major, $minor, $patch] = array_map('intval', explode('.', $version));

        return match ($bumpType) {
            'major' => sprintf('%d.0.0', $major + 1),
            'minor' => sprintf('%d.%d.0', $major, $minor + 1),
            'patch' => sprintf('%d.%d.%d', $major, $minor, $patch + 1),
            default => throw new InvalidArgumentException("Tipo inválido: {$bumpType} (usa major|minor|patch)"),
        };
    }

    /**
     * Escribe la nueva versión en composer.json conservando el formato.
     */
    private function writeVersion(string $version): void
    {
        $data = $this->readComposerData();
        $data['version'] = $version;

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        file_put_contents(self::COMPOSER_FILE, $json . "\n");
    }

    /**
     * Devuelve el contenido de composer.json como arreglo.
     *
     * @return array<string, mixed>
     */
    private function readComposerData(): array
    {
        $content = file_get_contents(self::COMPOSER_FILE);

        return json_decode((string)$content, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Aborta si hay cambios sin commitear para no mezclarlos con el release.
     */
    private function assertCleanWorkingTree(): void
    {
        if (trim((string)shell_exec('git status --porcelain')) !== '') {
            throw new RuntimeException('Hay cambios sin commitear. Haz commit antes del release.');
        }
    }

    /**
     * Ejecuta un comando de shell y lanza excepción si falla.
     */
    private function run(string $command): void
    {
        passthru($command, $exitCode);

        if ($exitCode !== 0) {
            throw new RuntimeException("Falló el comando: {$command}");
        }
    }
}

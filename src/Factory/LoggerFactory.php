<?php declare(strict_types=1);

namespace Map\Spillebord\Factory;

use Map\Spillebord\Config\Config;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    /**
     * @var array Log handler queue
     */
    private array $handler = [];

    /**
     * Loads configuration
     *
     * @param Config $config
     */
    public function __construct(private readonly Config $config) {
        $this->config->loadConfigFile(name: 'logger');
    }

    /**
     * Create the logger, and process the handler queue
     *
     * @param string|null $name
     * @return LoggerInterface
     */
    public function createLogger(string $name = null): LoggerInterface
    {
        // If we are testing, return the test logger - usually an instance of NullLogger
        if ($this->config->get(key: 'logger.testLogger')) {
            return $this->config->get(key: 'logger.testLogger');
        }

        // Prepare the logger name
        if ($name === null) {
            $name = $this->config->get(
                key: 'logger.name',
                default: uuid_create() // fallback to a UUID if no default name is configured
            );
        }

        // Create the logger
        $logger = new Logger($name);

        // Instantiate the handlers
        foreach ($this->handler as $handler) {
            $logger->pushHandler(handler: $handler);
        }

        // Reset the handler queue
        $this->handler = [];

        return $logger;
    }

    /**
     * Create a rotating file handler
     *
     * @param string|null $filename
     * @param int|null $level
     * @return self
     */
    public function addFileHandler(
        string $filename = null,
        int $level = null
    ) : self
    {
        // Process the filename into a fully qualified path.
        if ($filename === null) $filename = $this->config->get(key: 'logger.filename');
        $path = $this->config->get(key: 'logger.path');
        $filename = sprintf('%s/%s', $path, $filename);

        if ($level === null) {
            $level = $this->config->get(key: 'logger.level', default: Logger::NOTICE);
        }

        $rotatingFileHandler = new RotatingFileHandler(
            filename: $filename,
            maxFiles: 0,
            level: $level,
            bubble: true,
            filePermission: $this->config->get(key: 'logger.filePermissions', default: 0777)
        );

        $rotatingFileHandler->setFormatter(new LineFormatter(
            format: null,
            dateFormat: null,
            allowInlineLineBreaks: false,
            ignoreEmptyContextAndExtra: true
        ));

        $this->handler[] = $rotatingFileHandler;

        return $this;
    }
}

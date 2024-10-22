<?php

const SESSION_LOGGER_NAME = 'logger';
const SESSION_ENCRYPTION_NAME = 'encrypt';

const DEFAULT_LOGGER = \Rpj\Login\Logger\Concrete\FileLogger::class;
const DEFAULT_ENCRYPTION = \Rpj\Login\Encryption\CryptEncryption::class;
const DEFAULT_DATABASE = \Rpj\Login\Database\SqliteDatabase::class;

const STORAGE_PATH = 'storage/';
const DB_NAME = 'database';
const DB_TABLE_CLIENTS = 'clients';
const DB_TABLE_LOG = 'logs';
const DB_TABLE_LOG_COLUMN = 'data';

const LOGGER_HTTP_REQUEST_URL = 'https://webhook.site/ca153452-a296-4473-89ca-621bb8d5161c';
const LOGGER_HTTP_REQUEST_IS_GET = true;
const LOGGER_HTTP_REQUEST_DATA = 'log_value';

const LOGGER_FILENAME = 'logs.txt';

const SETTINGS_LOGGER_FILE = 'file';
const SETTINGS_LOGGER_HTTP = 'http';
const SETTINGS_LOGGER_DATABASE = 'database';
const SETTINGS_LOGGER_NONE = 'none';

const SETTINGS_ENCRYPTION_MD5 = 'md5';
const SETTINGS_ENCRYPTION_CRYPT = 'crypt';
const SETTINGS_ENCRYPTION_BCRYPT = 'bcrypt';
const SETTINGS_ENCRYPTION_NONE = 'none';

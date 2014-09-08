<?php

/**
 * This file is part of the NeoConnect package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace NeoConnect;

final class NeoEvents
{
    const NEO_KERNEL_STATEMENT = 'neoaction.query.transform_to_statement';

    const NEO_KERNEL_QUEUE = 'neoaction.statement.add_to_queue';

    const NEO_KERNEL_FLUSH_STRATEGY = 'neoaction.queue.perform_flush_strategy';

    const NEO_KERNEL_TRANSACTION = 'neoaction.queue.perform_commit';
}
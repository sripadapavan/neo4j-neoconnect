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
    const NEO_KERNEL_STATEMENT = 'neo_kernel.query_handler.transform_to_statement';

    const NEO_KERNEL_QUEUE = 'neo_kernel.query_handler.add_statement_to_queue';

    const NEO_KERNEL_FLUSH_STRATEGY = 'neo_kernel.query_handler.perform_flush_strategy';

    const NEO_KERNEL_TRANSACTION = 'neo_kernel.query_handler.queue_commit';
}
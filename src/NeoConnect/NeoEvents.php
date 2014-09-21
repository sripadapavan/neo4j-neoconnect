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
    const NEO_KERNEL_STATEMENT = 'neo_kernel.get_statement_for_query';

    const NEO_KERNEL_QUEUE = 'neo_kernel.get_queue_for_statement';

    const NEO_KERNEL_FLUSH_STRATEGY = 'neo_kernel.apply_flush_strategy';

    const NEO_KERNEL_TRANSACTION = 'neo_kernel.execute_queue_commit';
}

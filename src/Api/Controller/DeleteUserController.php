<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Api\Controller;

use Flarum\Core\Access\AssertPermissionTrait;
use Flarum\Core\Command\DeleteUser;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

class DeleteUserController extends AbstractDeleteController
{
    use AssertPermissionTrait;

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function delete(ServerRequestInterface $request)
    {
        $this->assertSudo($request);

        $this->bus->dispatch(
            new DeleteUser(array_get($request->getQueryParams(), 'id'), $request->getAttribute('actor'))
        );
    }
}

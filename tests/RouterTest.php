<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use StellarRouter\{Get,Post,Delete,Put,Patch,Router};

final class BasicController
{
    #[Get('/photos/{photo}/edit', 'photos.edit')]
    public function edit($photo): void 
    {
        print("edit: $photo");
    }

    #[Post('/photos', 'photos.create')]
    public function create(): void 
    {
        print("create");
    }
}

final class RouterTest extends TestCase
{
  private $router;

  protected function setUp(): void
  {
    $this->router = new Router;
    $this->router->registerRoutes(BasicController::class);
  }

  protected function tearDown(): void
  {
    $this->router = null;
  }

  public function testRouterResolvesCorrectRoute(): void
  {
    $route = $this->router->handleRequest('POST', '/photos');
    $this->assertSame('/photos', $route['path']);
    $this->assertSame('BasicController', $route['class']);
    $this->assertSame('create', $route['endpoint']);
    $this->assertSame([], $route['parameters']);
  }

  public function testRouterResolvesRoutePathWithParameters(): void
  {
    $route = $this->router->handleRequest('GET', '/photos/42/edit');
    $this->assertSame('42', $route['parameters']['photo']);
  }
}
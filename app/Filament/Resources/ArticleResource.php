<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = '記事管理';

    protected static ?string $modelLabel = '記事';

    protected static ?string $pluralModelLabel = '記事';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本情報')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('タイトル')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->label('URLスラッグ')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URLに使用されます（英数字とハイフンのみ）'),

                        Forms\Components\Select::make('category')
                            ->label('カテゴリ')
                            ->options(Article::getCategoryOptions())
                            ->required(),

                        Forms\Components\DatePicker::make('published_at')
                            ->label('公開日')
                            ->default(now()),
                    ])->columns(2),

            Forms\Components\Section::make('本文')
                ->schema([
                    Forms\Components\Textarea::make('content')
                        ->label('本文（HTML）')
                        ->required()
                        ->rows(25)
                        ->columnSpanFull()
                        ->helperText('HTMLタグを使用して記事を作成してください'),
                ]),

                Forms\Components\Section::make('サムネイル画像')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('サムネイル画像')
                            ->image()
                            ->directory('articles')
                            ->maxSize(5120)
                            ->helperText('推奨サイズ: 1200×630px'),
                    ]),

                Forms\Components\Section::make('公開設定')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('公開する')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('サムネイル')
                    ->circular()
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('カテゴリ')
                    ->formatStateUsing(fn($state) => Article::getCategoryOptions()[$state] ?? 'その他')
                    ->colors([
                        'primary' => 'preparation',
                        'success' => 'health',
                        'warning' => 'behavior',
                        'info' => 'basics',
                        'danger' => 'goods',
                        'secondary' => 'other',
                    ]),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('公開')
                    ->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('公開日')
                    ->date('Y年m月d日')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('カテゴリ')
                    ->options(Article::getCategoryOptions()),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('公開状態')
                    ->placeholder('すべて')
                    ->trueLabel('公開のみ')
                    ->falseLabel('非公開のみ'),

                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('公開日（開始）'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('公開日（終了）'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['published_from'], fn($q, $date) => $q->whereDate('published_at', '>=', $date))
                            ->when($data['published_until'], fn($q, $date) => $q->whereDate('published_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}

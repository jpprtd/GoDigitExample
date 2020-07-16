# GoDigitExample
 2020-07-15

    How to use this.
    [URL]/apis.php?action=[0]
    [0] = insert, update and delete. Choose this one.

    **GET CUSTOMER INFORMATION**
    [URL]/apis.php?action=get&cus=[1]
        [1] = all, or customer_id
        ex. [URL]/apis.php?action=get&cus=1
        ex. [URL]/apis.php?action=get&cus=all

    **INSERT CUSTOMER INFORMATION**
    [URL]/apis.php?action=insert
        *Require post key all of [1].
        [1] = 'fn', 'ln', 'tl' 
    
    **UPDATE CUSTOMER INFORMATION**
    [URL]/apis.php?action=update
        *Require post key all of [1].
        [1] = 'fn', 'ln', 'tl', 'id'

    **DELETE CUSTOMER INFORMATION**
    [URL]/apis.php?action=delete
        *Require post key all of [1].
        [1] = 'id'
        *Remark -> this functoin is remove real data,
        because proposition not tell about flag field for hide row of data.

